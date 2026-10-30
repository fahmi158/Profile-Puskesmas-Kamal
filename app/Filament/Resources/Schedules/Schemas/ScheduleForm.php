<?php

namespace App\Filament\Resources\Schedules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jadwal Layanan')
                    ->columns(2)
                    ->schema([
                        Select::make('service_id')
                            ->label('Layanan')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('service_name')
                            ->label('Nama Layanan (manual)')
                            ->helperText('Diisi bila layanan tidak ada di daftar.')
                            ->maxLength(255),
                        Select::make('day')
                            ->label('Hari')
                            ->required()
                            ->options([
                                'monday' => 'Senin',
                                'tuesday' => 'Selasa',
                                'wednesday' => 'Rabu',
                                'thursday' => 'Kamis',
                                'friday' => 'Jumat',
                                'saturday' => 'Sabtu',
                                'sunday' => 'Minggu',
                            ]),
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                        TimePicker::make('start_time')
                            ->label('Jam Mulai')
                            ->required()
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label('Jam Selesai')
                            ->required()
                            ->seconds(false),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Nonaktif',
                            ])
                            ->default('active')
                            ->required(),
                    ]),
            ]);
    }
}
