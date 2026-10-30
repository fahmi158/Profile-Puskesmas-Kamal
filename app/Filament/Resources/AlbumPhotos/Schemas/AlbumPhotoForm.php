<?php

namespace App\Filament\Resources\AlbumPhotos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlbumPhotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Foto Album')
                    ->columns(2)
                    ->schema([
                        Select::make('album_id')
                            ->label('Album')
                            ->relationship('album', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('caption')
                            ->label('Keterangan')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                        FileUpload::make('image')
                            ->label('Foto')
                            ->image()
                            ->required()
                            ->directory('albums/photos')
                            ->disk('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
