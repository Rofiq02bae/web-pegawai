<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('nip'),
                TextInput::make('golongan'),
                TextInput::make('jabatan'),
                TextInput::make('status')
                    ->required()
                    ->default('aktif'),
            ]);
    }
}
