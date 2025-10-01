<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_id')
                    ->relationship('asset', 'nama')
                    ->required(),
                TextInput::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                DatePicker::make('tanggal_pinjam')
                    ->required(),
                DatePicker::make('tanggal_kembali'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
            ]);
    }
}
