<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pesan Masuk')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->maxLength(30),
                        TextInput::make('subject')
                            ->label('Subjek')
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label('Pesan')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Toggle::make('is_read')
                            ->label('Sudah Dibaca')
                            ->inline(false),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'new' => 'Baru',
                                'read' => 'Dibaca',
                                'replied' => 'Dibalas',
                            ])
                            ->default('new')
                            ->required(),
                    ]),
            ]);
    }
}
