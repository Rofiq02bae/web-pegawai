<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('kode')
                    ->required(),
                TextInput::make('kategori'),
                TextInput::make('kondisi'),
                TextInput::make('status')
                    ->optional()
                    ->enum(['tersedia','dipinjam'])
                    ->default('tersedia'),
            ]);
    }
}
