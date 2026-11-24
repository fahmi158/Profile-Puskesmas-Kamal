<?php

namespace Tests\Unit;

use App\Filament\Forms\Components\HeicToWebpConverter;
use GdImage;
use Tests\TestCase;

class HeicToWebpConverterTest extends TestCase
{
    public function test_it_converts_heic_to_webp(): void
    {
        $source = base_path('vendor/maestroerror/php-heic-to-jpg/image1.heic');

        $this->assertFileExists($source);

        $contents = app(HeicToWebpConverter::class)->convert($source);

        $this->assertSame('RIFF', substr($contents, 0, 4));
        $this->assertSame('WEBP', substr($contents, 8, 4));

        $image = @imagecreatefromstring($contents);

        $this->assertInstanceOf(GdImage::class, $image);

        $this->assertGreaterThan(0, imagesx($image));
        $this->assertGreaterThan(0, imagesy($image));

        imagedestroy($image);
    }
}
