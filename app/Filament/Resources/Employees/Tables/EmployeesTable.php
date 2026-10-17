<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_number')
                    ->label('NIK')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('full_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('division.name')
                    ->label('Divisi')
                    ->badge()
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('employment_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'permanent',
                        'info' => 'contract',
                        'warning' => 'probation',
                        'gray' => 'intern',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'permanent' => 'Tetap',
                        'contract' => 'Kontrak',
                        'probation' => 'Probation',
                        'intern' => 'Magang',
                        default => $state,
                    }),

                TextColumn::make('phone')
                    ->label('No. HP')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('join_date')
                    ->label('Masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('division_id')
                    ->label('Divisi')
                    ->relationship('division', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('employment_status')
                    ->label('Status')
                    ->options([
                        'permanent' => 'Tetap',
                        'contract' => 'Kontrak',
                        'probation' => 'Probation',
                        'intern' => 'Magang',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('full_name');
    }
}
