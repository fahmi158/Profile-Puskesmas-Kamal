<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Agenda')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),
                Section::make('Waktu & Lokasi')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('event_date')
                            ->label('Tanggal')
                            ->required(),
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                        TimePicker::make('start_time')
                            ->label('Jam Mulai')
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label('Jam Selesai')
                            ->seconds(false),
                    ]),
                Section::make('Publikasi')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('events')
                            ->disk('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
            ]);
    }
}
