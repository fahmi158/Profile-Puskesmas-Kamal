<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
                Section::make('Informasi Dokumen')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('category')
                            ->label('Kategori')
                            ->maxLength(255),
                        TextInput::make('file_type')
                            ->label('Tipe File')
                            ->maxLength(20)
                            ->placeholder('pdf'),
                        TextInput::make('file_size')
                            ->label('Ukuran (byte)')
                            ->numeric()
                            ->helperText('Opsional. Digunakan untuk menampilkan ukuran berkas.'),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('file')
                            ->label('Berkas')
                            ->required()
                            ->directory('documents')
                            ->disk('public')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('published')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->seconds(false),
                    ]),
            ]);
    }
}
