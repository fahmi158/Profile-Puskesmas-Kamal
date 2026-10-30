<?php

namespace App\Filament\Resources\AlbumPhotos\Pages;

use App\Filament\Resources\AlbumPhotos\AlbumPhotoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlbumPhoto extends EditRecord
{
    protected static string $resource = AlbumPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
