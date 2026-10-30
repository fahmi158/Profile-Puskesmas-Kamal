<?php

namespace App\Filament\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('day')
            ->columns([
                TextColumn::make('service.name')
                    ->label('Layanan')
                    ->searchable()
                    ->sortable()
                    ->placeholder(fn ($record) => $record->service_name ?? '-'),
                TextColumn::make('day')
                    ->label('Hari')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu',
                        default => $state,
                    }),
                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time('H:i'),
                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time('H:i'),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(25),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'gray'),
            ])
            ->filters([
                SelectFilter::make('service_id')
                    ->label('Layanan')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('day')
                    ->label('Hari')
                    ->options([
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Nonaktif',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
