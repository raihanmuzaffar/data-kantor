<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Division;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pribadi')
                    ->schema([
                        TextInput::make('employee_number')
                            ->label('NIK Karyawan')
                            ->maxLength(30)
                            ->unique(ignoreRecord: true),

                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(255),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ]),

                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->maxLength(255),

                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->maxDate(now()),

                        TextInput::make('nik')
                            ->label('No. KTP')
                            ->maxLength(20),

                        TextInput::make('npwp')
                            ->label('No. NPWP')
                            ->maxLength(30),
                    ])
                    ->columns(2),

                Section::make('Kontak')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('No. HP')
                            ->tel()
                            ->maxLength(30),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->label('Kota')
                            ->maxLength(255),

                        TextInput::make('province')
                            ->label('Provinsi')
                            ->maxLength(255),

                        TextInput::make('emergency_contact_name')
                            ->label('Kontak Darurat — Nama')
                            ->maxLength(255),

                        TextInput::make('emergency_contact_phone')
                            ->label('Kontak Darurat — No. HP')
                            ->tel()
                            ->maxLength(30),
                    ])
                    ->columns(2),

                Section::make('Kepegawaian')
                    ->schema([
                        Select::make('division_id')
                            ->label('Divisi')
                            ->relationship('division', 'name')
                            ->searchable()
                            ->preload(),

                        TextInput::make('position')
                            ->label('Jabatan')
                            ->maxLength(255),

                        Select::make('employment_status')
                            ->label('Status Kepegawaian')
                            ->options([
                                'permanent' => 'Tetap',
                                'contract' => 'Kontrak',
                                'probation' => 'Probation',
                                'intern' => 'Magang',
                            ])
                            ->default('contract')
                            ->required(),

                        TextInput::make('salary')
                            ->label('Gaji')
                            ->numeric()
                            ->prefix('Rp'),

                        DatePicker::make('join_date')
                            ->label('Tanggal Masuk'),

                        DatePicker::make('end_date')
                            ->label('Tanggal Keluar'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Dokumen')
                    ->schema([
                        FileUpload::make('ktp_file')
                            ->label('Scan KTP')
                            ->image()
                            ->directory('employees/ktp')
                            ->maxSize(2048),

                        FileUpload::make('npwp_file')
                            ->label('Scan NPWP')
                            ->image()
                            ->directory('employees/npwp')
                            ->maxSize(2048),

                        FileUpload::make('contract_file')
                            ->label('Kontrak Kerja')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('employees/contracts')
                            ->maxSize(5120),
                    ])
                    ->columns(3)
                    ->collapsible(),
            ]);
    }
}
