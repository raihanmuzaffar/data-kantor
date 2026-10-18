<?php

namespace App\Filament\Resources\Reimbursements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReimbursementForm
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
                    ->default(fn () => auth()->user()?->employee?->id)
                    ->disabled(fn () => auth()->user()?->hasRole('karyawan'))
                    ->dehydrated()
                    ->required(),

                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'transport' => 'Transportasi',
                        'meals' => 'Makan & Minum',
                        'supplies' => 'Perlengkapan',
                        'accommodation' => 'Akomodasi',
                        'communication' => 'Komunikasi',
                        'other' => 'Lainnya',
                    ])
                    ->required()
                    ->default('other'),

                TextInput::make('amount')
                    ->label('Nominal (Rp)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->prefix('Rp'),

                DatePicker::make('expense_date')
                    ->label('Tanggal Pengeluaran')
                    ->required()
                    ->default(now()),

                Textarea::make('description')
                    ->label('Keterangan')
                    ->rows(3)
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('receipt')
                    ->label('Bukti / Nota')
                    ->collection('receipt')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ])->columns(2);
    }
}
