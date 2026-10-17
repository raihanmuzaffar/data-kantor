<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_code')
                    ->label('Kode Aset')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                TextInput::make('name')
                    ->label('Nama Aset')
                    ->required()
                    ->maxLength(255),

                TextInput::make('category')
                    ->label('Kategori (Laptop/Kendaraan/dll)')
                    ->required(),

                Select::make('employee_id')
                    ->label('Dipegang Oleh')
                    ->relationship('employee', 'full_name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Belum ada'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Tersedia (Di Gudang)',
                        'in_use' => 'Digunakan',
                        'maintenance' => 'Dalam Perbaikan',
                        'broken' => 'Rusak',
                    ])
                    ->default('available')
                    ->required(),

                DatePicker::make('purchase_date')
                    ->label('Tanggal Pembelian'),

                TextInput::make('price')
                    ->label('Harga Beli')
                    ->numeric()
                    ->prefix('Rp'),

                Textarea::make('notes')
                    ->label('Catatan Tambahan')
                    ->columnSpanFull(),
            ])->columns(2);
    }
}
