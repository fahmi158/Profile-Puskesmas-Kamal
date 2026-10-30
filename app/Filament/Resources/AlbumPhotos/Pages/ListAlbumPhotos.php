<?php

namespace App\Filament\Resources\AlbumPhotos\Pages;

use App\Filament\Resources\AlbumPhotos\AlbumPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlbumPhotos extends ListRecords
{
    protected static string $resource = AlbumPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
