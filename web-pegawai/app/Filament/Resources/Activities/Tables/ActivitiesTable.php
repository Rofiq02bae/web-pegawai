<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\BadgeColumn;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_id')
                    ->numeric()
                    ->sortable(),
                BadgeColumn::make('jenis')
                    ->searchable(),
                TextColumn::make('tanggal_awal')
                    ->date()
                    ->sortable(),
                TextColumn::make('tanggal_akhir')
                    ->date()
                    ->sortable(),
                TextColumn::make('keperluan')
                    ->searchable()
                    ->limit(50),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->options([
                        'dinas'=>'Dinas',
                        'dinas_luar'=>'Dinas Luar',
                        'cuti'=>'Cuti',
                        'diklat'=>'Diklat',
                        'lainnya'=>'Lainnya',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
