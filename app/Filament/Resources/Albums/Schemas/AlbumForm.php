<?php

namespace App\Filament\Resources\Albums\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Album')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Album')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('category')
                            ->label('Kategori')
                            ->maxLength(255),
                        DatePicker::make('event_date')
                            ->label('Tanggal Kegiatan'),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('cover_image')
                            ->label('Gambar Sampul')
                            ->image()
                            ->directory('albums')
                            ->disk('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),
                Section::make('Foto Album')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship()
                            ->label('Daftar Foto')
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Foto')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Foto')
                                    ->image()
                                    ->required()
                                    ->directory('albums/photos')
                                    ->disk('public'),
                                TextInput::make('caption')
                                    ->label('Keterangan')
                                    ->maxLength(255),
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }
}
