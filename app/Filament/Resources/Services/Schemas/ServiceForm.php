<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('schedule')
                            ->label('Jadwal Singkat')
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                        TextInput::make('icon')
                            ->label('Ikon (nama heroicon)')
                            ->default('heart')
                            ->helperText('Contoh: heart, user, shield-check')
                            ->maxLength(255),
                        Toggle::make('featured')
                            ->label('Layanan Unggulan')
                            ->inline(false),
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                        RichEditor::make('requirements')
                            ->label('Persyaratan')
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('published')
                            ->required(),
                    ]),
            ]);
    }
}
