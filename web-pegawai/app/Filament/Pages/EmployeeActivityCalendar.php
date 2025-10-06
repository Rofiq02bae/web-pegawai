<?php

namespace App\Filament\Pages;

use App\Models\Activity;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;
use Livewire\Attributes\On;

class EmployeeActivityCalendar extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-calendar';
    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Aktivitas';
    protected string $view = 'filament.pages.employee-activity-calendar';

    public static function canAccess(): bool
    {
        return auth()->user()->can('view activities');
    }

    public $events = [];

    public function mount()
    {
        $this->loadEvents();
    }

    #[On('refresh-calendar')]
    public function refreshCalendar()
    {
        $this->loadEvents();
        $this->dispatch('calendar-updated');
    }

    protected function loadEvents()
    {
        try {
            $activities = Activity::with('employee')
                ->whereNotNull('tanggal_awal')
                ->get();

            $this->events = $activities->map(function ($activity) {
                // Ensure we have valid dates
                $startDate = $activity->tanggal_awal;
                $endDate = $activity->tanggal_akhir ?: $activity->tanggal_awal;
                
                if (!$startDate) {
                    return null; // Skip invalid dates
                }

                return [
                    'id' => $activity->id,
                    'title' => ($activity->employee->name ?? 'Unknown') . ' - ' . ($activity->keperluan ?? 'No description'),
                    'start' => $startDate->format('Y-m-d'),
                    'end' => $endDate ? $endDate->format('Y-m-d') : $startDate->format('Y-m-d'),
                    'description' => $activity->uraian ?? '',
                    'color' => $this->getStatusColor($activity->status),
                    'borderColor' => $this->getStatusColor($activity->status),
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'employee' => $activity->employee->name ?? 'Unknown',
                        'jenis' => $activity->jenis ?? 'N/A',
                        'status' => $activity->status,
                        'description' => $activity->uraian ?? '',
                        'nomor_surat' => $activity->nomor_surat ?? '',
                    ],
                ];
            })
            ->filter() // Remove null values
            ->values() // Reindex array
            ->toArray();

            logger()->info('Calendar events loaded', ['count' => count($this->events)]);
            
        } catch (\Exception $e) {
            logger()->error('Error loading calendar events', ['error' => $e->getMessage()]);
            $this->events = [];
        }
    }

    protected function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => '#fbbf24',   // yellow-400
            'disetujui' => '#10b981', // green-500  
            'ditolak' => '#ef4444',   // red-500
            default => '#6b7280',     // gray-500
        };
    }
}
