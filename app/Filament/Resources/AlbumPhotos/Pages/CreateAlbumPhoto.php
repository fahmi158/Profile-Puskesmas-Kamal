<?php

namespace App\Filament\Resources\AlbumPhotos\Pages;

use App\Filament\Resources\AlbumPhotos\AlbumPhotoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlbumPhoto extends CreateRecord
{
    protected static string $resource = AlbumPhotoResource::class;
}
