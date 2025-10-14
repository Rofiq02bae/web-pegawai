<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WorkSchedule extends Model
{
    protected $fillable = [
        'employee_id',
        'work_date',
        'shift',
        'status',
        'check_in',
        'check_out',
        'reason',
        'notes',
    ];

    protected $casts = [
        'work_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /**
     * Get the employee that owns the work schedule.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Check if the schedule is for today
     */
    public function isToday(): bool
    {
        return $this->work_date->isToday();
    }

    /**
     * Get working hours duration
     */
    public function getWorkingHoursAttribute(): ?string
    {
        if ($this->check_in && $this->check_out) {
            $diff = $this->check_out->diff($this->check_in);
            return $diff->format('%h:%I');
        }
        return null;
    }

    /**
     * Check if employee is currently checked in
     */
    public function isCheckedIn(): bool
    {
        return $this->check_in && !$this->check_out;
    }

    /**
     * Check if schedule is on weekend
     */
    public function isWeekend(): bool
    {
        return $this->work_date->isWeekend();
    }

    /**
     * Scope for today's schedules
     */
    public function scopeToday($query)
    {
        return $query->whereDate('work_date', now());
    }

    /**
     * Scope for this week's schedules
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('work_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope for active work statuses (not leave/off)
     */
    public function scopeActiveWork($query)
    {
        return $query->whereIn('status', ['Hadir', 'Dinas Dalam', 'Dinas Luar']);
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Hadir' => 'success',
            'Dinas Dalam' => 'primary',
            'Dinas Luar' => 'info',
            'Cuti', 'Izin' => 'warning',
            'Sakit', 'Alpha' => 'danger',
            'Libur' => 'gray',
            default => 'secondary',
        };
    }

    /**
     * Get status icon for UI
     */
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'Hadir' => 'heroicon-o-check-circle',
            'Dinas Dalam' => 'heroicon-o-building-office',
            'Dinas Luar' => 'heroicon-o-map-pin',
            'Cuti' => 'heroicon-o-calendar-days',
            'Izin' => 'heroicon-o-hand-raised',
            'Sakit' => 'heroicon-o-face-frown',
            'Alpha' => 'heroicon-o-x-circle',
            'Libur' => 'heroicon-o-home',
            default => 'heroicon-o-question-mark-circle',
        };
    }
}
