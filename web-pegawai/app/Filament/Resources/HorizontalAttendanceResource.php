<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HorizontalAttendanceResource\Pages;
use App\Filament\Resources\Attendances\Tables\HorizontalAttendanceTable;
use App\Models\Employee;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Carbon\Carbon;

class HorizontalAttendanceResource extends Resource
{
    protected static ?string $model = Employee::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-table-cells';
    }

    public static function getNavigationLabel(): string
    {
        return 'Rekap Horizontal';
    }

    public static function getModelLabel(): string
    {
        return 'Rekap Presensi Horizontal';
    }
    
    public static function getPluralModelLabel(): string
    {
        return 'Rekap Presensi Horizontal';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Presensi';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function table(Table $table): Table
    {
        // Get month/year from request or use current
        $month = request('tableFilters.month.value', now()->month);
        $year = request('tableFilters.year.value', now()->year);
        
        return HorizontalAttendanceTable::configure($table, $year, $month);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHorizontalAttendance::route('/'),
        ];
    }

    // Disable CRUD operations - this is read-only view
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canView($record): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $stats = HorizontalAttendanceTable::getMonthlyStats(now()->year, now()->month);
        return $stats['attendance_rate'] . '%';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $stats = HorizontalAttendanceTable::getMonthlyStats(now()->year, now()->month);
        $rate = $stats['attendance_rate'];
        
        if ($rate >= 90) return 'success';
        if ($rate >= 75) return 'warning'; 
        return 'danger';
    }
}