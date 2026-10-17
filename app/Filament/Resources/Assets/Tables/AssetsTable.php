<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_code')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                TextColumn::make('employee.full_name')
                    ->label('Dipegang Oleh')
                    ->placeholder('Gudang'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'available',
                        'primary' => 'in_use',
                        'warning' => 'maintenance',
                        'danger' => 'broken',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Tersedia',
                        'in_use' => 'Digunakan',
                        'maintenance' => 'Perbaikan',
                        'broken' => 'Rusak',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Tersedia',
                        'in_use' => 'Digunakan',
                        'maintenance' => 'Perbaikan',
                        'broken' => 'Rusak',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
