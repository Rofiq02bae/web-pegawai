<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //fillable tabel activity
    protected $fillable = [
        'employee_id',
        'jenis',
        'tanggal_awal',
        'tanggal_akhir',
        'nomor_surat',
        'tanggal_surat',
        'keperluan',
        'uraian',
    ];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
        'tanggal_surat' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
