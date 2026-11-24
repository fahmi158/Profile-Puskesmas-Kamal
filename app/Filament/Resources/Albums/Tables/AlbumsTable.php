<?php

namespace App\Filament\Resources\Albums\Tables;

use App\Models\Album;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('event_date', 'desc')
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Sampul')
                    ->disk('public')
                    ->square()
                    ->size(48),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),
                TextColumn::make('photos_count')
                    ->label('Jumlah Foto')
                    ->counts('photos'),
                TextColumn::make('event_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
                SelectFilter::make('category')
                    ->options(fn () => Album::query()
                        ->whereNotNull('category')
                        ->distinct()
                        ->pluck('category', 'category')
                        ->all()),
            ])
            ->recordActions([
                EditAction::make(),

                Action::make('deleteThumbnail')
                    ->label('Hapus Thumbnail')
                    ->icon('heroicon-o-photo')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Thumbnail')
                    ->modalDescription('Apakah Anda yakin ingin menghapus thumbnail album ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->visible(fn (Album $record): bool => filled($record->cover_image))
                    ->action(function (Album $record): void {
                        if ($record->cover_image) {
                            Storage::disk('public')->delete($record->cover_image);

                            $record->update([
                                'cover_image' => null,
                            ]);
                        }
                    })
                    ->successNotificationTitle('Thumbnail berhasil dihapus'),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
