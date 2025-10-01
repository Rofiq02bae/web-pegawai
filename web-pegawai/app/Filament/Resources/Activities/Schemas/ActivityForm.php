<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee','name')
                    ->searchable()
                    ->required(),
                Select::make('jenis')
                    ->options([
                        'dinas'=>'Dinas',
                        'dinas_luar'=>'Dinas Luar',
                        'cuti'=>'Cuti',
                        'diklat'=>'Diklat',
                        'lainnya'=>'Lainnya',
                    ])
                    ->required(),
                DatePicker::make('tanggal_awal')
                    ->required(),
                DatePicker::make('tanggal_akhir'),
                TextInput::make('nomor_surat'),
                DatePicker::make('tanggal_surat'),
                TextInput::make('keperluan'),
                Textarea::make('uraian')
                    ->columnSpanFull(),
            ]);
    }
}
