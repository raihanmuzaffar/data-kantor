<?php

namespace App\Filament\Resources\Divisions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DivisionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Divisi')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('code')
                    ->label('Kode')
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->helperText('Kode singkat divisi, mis. IT, HR, FIN'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('head_user_id')
                    ->label('Kepala Divisi')
                    ->relationship('head', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Belum ditentukan'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
