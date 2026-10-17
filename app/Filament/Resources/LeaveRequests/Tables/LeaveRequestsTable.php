<?php

namespace App\Filament\Resources\LeaveRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeaveRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y'),
                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                TextColumn::make('approver.name')
                    ->label('Disetujui Oleh')
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->recordActions([
                // Tombol Approve menggunakan Policy
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()->can('approve', $record))
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                    }),

                // Tombol Reject menggunakan Policy
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => auth()->user()->can('reject', $record))
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'rejected',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
