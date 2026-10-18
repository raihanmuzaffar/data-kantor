<?php

namespace App\Filament\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee', 'full_name')
                    ->label('Karyawan')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                DateTimePicker::make('clock_in')
                    ->label('Clock In')
                    ->seconds(false),

                DateTimePicker::make('clock_out')
                    ->label('Clock Out')
                    ->seconds(false),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'early_leave' => 'Pulang Awal',
                        'half_day' => 'Setengah Hari',
                        'absent' => 'Tidak Hadir',
                        'leave' => 'Cuti / Izin',
                    ])
                    ->required()
                    ->default('present'),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2);
    }
}
