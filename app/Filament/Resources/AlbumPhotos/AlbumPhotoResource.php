<?php

namespace App\Filament\Resources\AlbumPhotos;

use App\Filament\Resources\AlbumPhotos\Pages\CreateAlbumPhoto;
use App\Filament\Resources\AlbumPhotos\Pages\EditAlbumPhoto;
use App\Filament\Resources\AlbumPhotos\Pages\ListAlbumPhotos;
use App\Filament\Resources\AlbumPhotos\Schemas\AlbumPhotoForm;
use App\Filament\Resources\AlbumPhotos\Tables\AlbumPhotosTable;
use App\Models\AlbumPhoto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlbumPhotoResource extends Resource
{
    protected static ?string $model = AlbumPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AlbumPhotoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlbumPhotosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlbumPhotos::route('/'),
            'create' => CreateAlbumPhoto::route('/create'),
            'edit' => EditAlbumPhoto::route('/{record}/edit'),
        ];
    }
}
