<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class HorizontalAttendanceTable
{
    // Status icons mapping
    private static array $statusIcons = [
        'hadir' => '🟢',
        'sakit' => '🔴', 
        'izin' => '🟡',
        'cuti' => '🟣',
        'dinas_dalam' => '🔵',
        'dinas_luar' => '🔷',
        'alpha' => '❌',
        'libur' => '⚪',
    ];

    // Status labels for summary
    private static array $statusLabels = [
        'hadir' => 'H',
        'sakit' => 'S',
        'izin' => 'I', 
        'cuti' => 'C',
        'dinas_dalam' => 'DD',
        'dinas_luar' => 'DL',
        'alpha' => 'A',
        'libur' => 'L',
    ];

    public static function configure(Table $table, int $year = null, int $month = null): Table
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;
        
        // Get days in month
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $monthName = Carbon::create($year, $month, 1)->format('F Y');
        
        // Build columns array - Fixed columns first
        $columns = [
            TextColumn::make('nip')
                ->label('NIP')
                ->searchable()
                ->sortable()
                ->weight('semibold')
                ->copyable()
                ->width('100px')
                ->extraAttributes(['class' => 'sticky left-0 bg-white border-r-2 border-gray-200 z-10']),
                
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->weight('semibold')
                ->wrap()
                ->width('200px')
                ->extraAttributes(['class' => 'sticky left-[100px] bg-white border-r-2 border-gray-200 z-10']),
                
            TextColumn::make('position')
                ->label('Jabatan')
                ->searchable()
                ->sortable()
                ->wrap()
                ->width('150px')
                ->placeholder('N/A')
                ->extraAttributes(['class' => 'sticky left-[300px] bg-white border-r-2 border-gray-200 z-10']),
        ];

        // Add dynamic date columns (1-31)
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $dayName = $date->format('D'); // Mon, Tue, etc
            $isWeekend = $date->isWeekend();
            $isToday = $date->isToday();
            
            $columns[] = TextColumn::make("day_{$day}")
                ->label((string) $day)
                ->html()
                ->alignCenter()
                ->width('40px')
                ->getStateUsing(function (Employee $record) use ($date) {
                    return self::getAttendanceIcon($record->id, $date);
                })
                ->tooltip(function (Employee $record) use ($date, $dayName) {
                    return self::getAttendanceTooltip($record->id, $date, $dayName);
                })
                ->extraHeaderAttributes([
                    'class' => implode(' ', [
                        'text-center font-medium text-xs',
                        $isWeekend ? 'bg-red-100 text-red-700' : 'bg-gray-50',
                        $isToday ? 'ring-2 ring-blue-400 bg-blue-50' : ''
                    ]),
                    'style' => 'min-width: 40px; max-width: 40px; padding: 8px 4px;',
                    'title' => $date->format('D, d M Y') . ($isToday ? ' (Hari ini)' : '')
                ])
                ->extraAttributes([
                    'class' => implode(' ', [
                        'text-center cursor-help',
                        $isWeekend ? 'bg-red-25' : '',
                        $isToday ? 'bg-blue-25' : ''
                    ]),
                    'style' => 'min-width: 40px; max-width: 40px; padding: 8px 4px; font-size: 18px;'
                ]);
        }

        // Add summary/rekap column (sticky right)
        $columns[] = TextColumn::make('monthly_summary')
            ->label('Rekap')
            ->html()
            ->getStateUsing(function (Employee $record) use ($year, $month) {
                return self::getMonthlyRecap($record->id, $year, $month);
            })
            ->width('120px')
            ->extraAttributes([
                'class' => 'sticky right-0 bg-white border-l-2 border-gray-200 z-10 text-xs font-medium',
                'style' => 'min-width: 120px;'
            ]);

        return $table
            ->query(
                Employee::query()
                    ->with(['attendances' => function ($query) use ($year, $month) {
                        $query->forMonth($year, $month);
                    }])
                    ->orderBy('nip')
            )
            ->columns($columns)
            ->filters([
                SelectFilter::make('month')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ])
                    ->default($month)
                    ->query(function (Builder $query, array $data): Builder {
                        // This filter doesn't affect the query, it's handled in the resource
                        return $query;
                    }),
                    
                SelectFilter::make('year')
                    ->label('Tahun')
                    ->options([
                        2023 => '2023', 2024 => '2024', 
                        2025 => '2025', 2026 => '2026',
                    ])
                    ->default($year)
                    ->query(function (Builder $query, array $data): Builder {
                        // This filter doesn't affect the query, it's handled in the resource
                        return $query;
                    }),
                    
                SelectFilter::make('jabatan')
                    ->label('Jabatan')
                    ->options(function () {
                        return Employee::whereNotNull('jabatan')
                            ->distinct()
                            ->pluck('jabatan', 'jabatan')
                            ->toArray();
                    })
                    ->placeholder('Semua Jabatan')
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            !empty($data['value']),
                            fn (Builder $query) => $query->where('jabatan', $data['value'])
                        );
                    }),

                SelectFilter::make('status_filter')
                    ->label('Filter Status')
                    ->options([
                        'hadir_only' => 'Hanya yang Hadir',
                        'absent_only' => 'Hanya yang Absen',
                        'perfect_attendance' => 'Kehadiran Sempurna',
                    ])
                    ->query(function (Builder $query, array $data) use ($year, $month) {
                        if (!empty($data['value'])) {
                            $startDate = Carbon::create($year, $month, 1);
                            $endDate = $startDate->copy()->endOfMonth();
                            
                            switch ($data['value']) {
                                case 'hadir_only':
                                    $query->whereHas('attendances', function ($q) use ($startDate, $endDate) {
                                        $q->whereBetween('date', [$startDate, $endDate])
                                          ->where('status', 'hadir');
                                    });
                                    break;
                                case 'absent_only':
                                    $query->whereHas('attendances', function ($q) use ($startDate, $endDate) {
                                        $q->whereBetween('date', [$startDate, $endDate])
                                          ->whereIn('status', ['sakit', 'izin', 'alpha']);
                                    });
                                    break;
                                case 'perfect_attendance':
                                    $workingDays = $startDate->diffInWeekdays($endDate) + 1;
                                    $query->whereHas('attendances', function ($q) use ($startDate, $endDate) {
                                        $q->whereBetween('date', [$startDate, $endDate])
                                          ->where('status', 'hadir');
                                    }, '=', $workingDays);
                                    break;
                            }
                        }
                        return $query;
                    }),
            ])
            ->searchable()
            ->defaultSort('nip')
            ->paginated([10, 25, 50, 100])
            ->striped()
            ->emptyStateHeading('Tidak ada data pegawai')
            ->emptyStateDescription("Belum ada data pegawai untuk periode {$monthName}")
            ->persistFiltersInSession()
            ->persistSortInSession()
            ->poll('30s') // Auto refresh
            ->deferLoading()
            ->extremePaginationLinks()
            ->headerActions([
                // Will be added in the resource page
            ])
            ->description("📅 Rekap Presensi Horizontal - {$monthName} • Format matrix untuk analisis pola kehadiran pegawai");
    }

    /**
     * Get attendance icon for specific date
     */
    private static function getAttendanceIcon(int $employeeId, Carbon $date): string
    {
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $date)
            ->first();

        if (!$attendance) {
            // Check if it's weekend (default libur)
            if ($date->isWeekend()) {
                return '<span style="font-size: 18px;" title="Libur Weekend">⚪</span>';
            }
            // No data for weekday (Alpha)
            return '<span style="font-size: 18px;" title="Tanpa Keterangan">❌</span>';
        }

        $icon = self::$statusIcons[$attendance->status] ?? '❓';
        $title = ucfirst(str_replace('_', ' ', $attendance->status));
        
        return "<span style='font-size: 18px;' title='{$title}'>{$icon}</span>";
    }

    /**
     * Get detailed tooltip for attendance
     */
    private static function getAttendanceTooltip(int $employeeId, Carbon $date, string $dayName): string
    {
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $date)
            ->first();

        $baseTooltip = "{$dayName}, {$date->format('d M Y')}";

        if (!$attendance) {
            if ($date->isWeekend()) {
                return $baseTooltip . "\n📅 Libur Weekend";
            }
            return $baseTooltip . "\n❌ Tidak ada data presensi";
        }

        $tooltip = $baseTooltip . "\n📋 " . ucfirst(str_replace('_', ' ', $attendance->status));
        
        if ($attendance->check_in) {
            $tooltip .= "\n🕐 Masuk: " . $attendance->check_in->format('H:i');
        }
        
        if ($attendance->check_out) {
            $tooltip .= "\n🕕 Pulang: " . $attendance->check_out->format('H:i:s');
            
            if ($attendance->check_in) {
                $diff = $attendance->check_out->diff($attendance->check_in);
                $tooltip .= "\n⏱️ Durasi: " . $diff->format('%h jam %i menit');
            }
        }
        
        if ($attendance->notes) {
            $tooltip .= "\n📝 " . $attendance->notes;
        }

        return $tooltip;
    }

    /**
     * Generate monthly recap/summary for employee
     */
    private static function getMonthlyRecap(int $employeeId, int $year, int $month): string
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        $attendances = Attendance::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('status');

        $summary = '';
        $totalWorkingDays = $startDate->diffInWeekdays($endDate) + 1;
        
        foreach (self::$statusLabels as $status => $label) {
            $count = $attendances->get($status, collect())->count();
            if ($count > 0) {
                $color = self::getStatus($status);
                $summary .= "<span class='inline-block px-1 py-0.5 rounded text-xs font-medium {$color} mr-1 mb-1'>";
                $summary .= "{$count}{$label}";
                $summary .= "</span>";
            }
        }

        // Add attendance percentage
        $presentDays = $attendances->get('hadir', collect())->count();
        $percentage = $totalWorkingDays > 0 ? round(($presentDays / $totalWorkingDays) * 100) : 0;
        
        $summary .= "<div class='mt-1 text-xs text-gray-600'>";
        $summary .= "📊 {$percentage}% kehadiran";
        $summary .= "</div>";

        return $summary ?: '<span class="text-gray-400 text-xs">Tidak ada data</span>';
    }

    /**
     * Get status color class for badges
     */
    private static function getStatus(string $status): string
    {
        return match ($status) {
            'hadir' => 'Hadir',
            'sakit' => 'bg-red-100 text-red-800',
            'izin' => 'Izin',
            'cuti' => 'Cuti',
            'dinas_dalam' => 'Dinas Dalam',
            'dinas_luar' => 'Dinas Luar',
            'alpha' => 'Alpha',
            'libur' => 'Libur',
            default => 'Libur',
        };
    }

    /**
     * Get attendance statistics for the month
     */
    public static function getMonthlyStats(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = $startDate->diffInWeekdays($endDate) + 1;
        
        $totalEmployees = Employee::count();
        $totalPossibleAttendance = $totalEmployees * $workingDays;
        
        $actualAttendance = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'hadir')
            ->count();
            
        $attendanceRate = $totalPossibleAttendance > 0 
            ? round(($actualAttendance / $totalPossibleAttendance) * 100, 1)
            : 0;

        return [
            'total_employees' => $totalEmployees,
            'working_days' => $workingDays,
            'total_present' => $actualAttendance,
            'attendance_rate' => $attendanceRate,
            'total_absent' => Attendance::whereBetween('date', [$startDate, $endDate])
                ->whereIn('status', ['sakit', 'izin', 'alpha'])
                ->count(),
            'perfect_attendance' => Employee::whereHas('attendances', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate])
                      ->where('status', 'hadir');
            }, '=', $workingDays)->count(),
        ];
    }

}