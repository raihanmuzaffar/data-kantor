<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('employee.full_name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('employee.division.name')
                    ->label('Divisi')
                    ->toggleable(),

                TextColumn::make('clock_in')
                    ->label('Clock In')
                    ->dateTime('H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('clock_out')
                    ->label('Clock Out')
                    ->dateTime('H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('work_duration')
                    ->label('Durasi')
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'present',
                        'warning' => 'late',
                        'info' => 'early_leave',
                        'gray' => 'half_day',
                        'danger' => 'absent',
                        'primary' => 'leave',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'early_leave' => 'Pulang Awal',
                        'half_day' => 'Setengah Hari',
                        'absent' => 'Tidak Hadir',
                        'leave' => 'Cuti / Izin',
                        default => $state,
                    }),

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'early_leave' => 'Pulang Awal',
                        'half_day' => 'Setengah Hari',
                        'absent' => 'Tidak Hadir',
                        'leave' => 'Cuti / Izin',
                    ]),

                SelectFilter::make('employee_id')
                    ->label('Karyawan')
                    ->relationship('employee', 'full_name')
                    ->searchable()
                    ->preload(),

                Filter::make('date')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('date', '>=', $date))
                            ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('date', '<=', $date));
                    }),

                Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn (Builder $query): Builder => $query->whereDate('date', today()))
                    ->toggle(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();
                if ($user && $user->hasRole('karyawan') && $user->employee) {
                    $query->where('employee_id', $user->employee->id);
                }
            });
    }
}
