<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Berita')
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
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'Berita' => 'Berita',
                                'Artikel Kesehatan' => 'Artikel Kesehatan',
                                'Pengumuman' => 'Pengumuman',
                            ])
                            ->searchable(),
                        Select::make('user_id')
                            ->label('Penulis')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id()),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->label('Isi Berita')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columns(3)
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('news')
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
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->seconds(false),
                        Toggle::make('is_featured')
                            ->label('Berita Utama')
                            ->inline(false),
                    ]),
            ]);
    }
}
