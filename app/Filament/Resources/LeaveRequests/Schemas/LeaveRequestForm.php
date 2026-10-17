<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee', 'full_name')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->preload()
                    ->default(fn () => auth()->user()->employee?->id) // Otomatis pilih diri sendiri jika karyawan
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),

                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->afterOrEqual('start_date'),

                Textarea::make('reason')
                    ->label('Alasan Cuti')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(3);
    }
}
