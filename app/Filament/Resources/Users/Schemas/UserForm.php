<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pengguna')
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
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->helperText('Biarkan kosong saat mengubah data bila tidak ingin mengganti kata sandi.'),
                        Select::make('role')
                            ->label('Peran')
                            ->options([
                                'admin' => 'Admin',
                                'petugas' => 'Petugas',
                            ])
                            ->required()
                            ->default('petugas'),
                        DateTimePicker::make('email_verified_at')
                            ->label('Waktu Verifikasi Email')
                            ->seconds(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
