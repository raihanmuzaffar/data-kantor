<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Dokumen')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->options([
                                'active' => 'Aktif',
                                'archived' => 'Diarsipkan',
                            ])
                            ->default('active')
                            ->required(),

                        DatePicker::make('expires_at')
                            ->label('Tanggal Kadaluarsa (Opsional)'),

                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),

                        // Ini komponen Spatie Media Library untuk upload file
                        SpatieMediaLibraryFileUpload::make('document_file')
                            ->label('Upload File (PDF/Word/Excel)')
                            ->collection('document_file')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
