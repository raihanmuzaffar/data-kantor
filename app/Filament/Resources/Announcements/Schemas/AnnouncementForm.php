<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Kosongkan untuk generate otomatis dari isi')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        RichEditor::make('body')
                            ->label('Isi Pengumuman')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Select::make('priority')
                            ->label('Prioritas')
                            ->options([
                                'low' => 'Rendah',
                                'normal' => 'Normal',
                                'high' => 'Tinggi',
                                'urgent' => 'Mendesak',
                            ])
                            ->default('normal')
                            ->required(),

                        Select::make('target_type')
                            ->label('Target')
                            ->options([
                                'all' => 'Semua Karyawan',
                                'division' => 'Divisi Tertentu',
                            ])
                            ->default('all')
                            ->live()
                            ->required(),

                        Select::make('target_division_id')
                            ->label('Divisi Target')
                            ->relationship('division', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('target_type') === 'division')
                            ->required(fn ($get) => $get('target_type') === 'division'),

                        Toggle::make('is_published')
                            ->label('Publish')
                            ->default(false)
                            ->live()
                            ->helperText('Jika diaktifkan, pengumuman langsung tayang'),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publish')
                            ->visible(fn ($get) => $get('is_published')),

                        DateTimePicker::make('expires_at')
                            ->label('Berakhir Pada')
                            ->helperText('Kosongkan jika tidak ada batas waktu'),
                    ])
                    ->columns(2),
            ]);
    }
}
