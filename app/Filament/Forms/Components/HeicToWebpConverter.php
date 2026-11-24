<?php

namespace App\Filament\Forms\Components;

use GdImage;
use Maestroerror\HeicToJpg;
use RuntimeException;
use Throwable;

class HeicToWebpConverter
{
    private const WEBP_QUALITY = 82;

    public function convert(string $heicPath): string
    {
        $jpegPath = $this->temporaryPath('heic-jpg');

        try {
            $this->writeJpeg($heicPath, $jpegPath);

            $image = $this->createImage($jpegPath);
            $image = $this->orient($image, $this->exifOrientation($jpegPath));

            $webpPath = $this->temporaryPath('heic-webp');

            try {
                if (! imagewebp($image, $webpPath, self::WEBP_QUALITY)) {
                    throw new RuntimeException('Foto HEIC gagal dikonversi menjadi WebP.');
                }

                $contents = file_get_contents($webpPath);

                if ($contents === false) {
                    throw new RuntimeException('Hasil konversi WebP tidak dapat dibaca.');
                }

                return $contents;
            } finally {
                imagedestroy($image);
                @unlink($webpPath);
            }
        } finally {
            @unlink($jpegPath);
            $this->deleteConverterOutputs($heicPath);
        }
    }

    private function writeJpeg(string $heicPath, string $jpegPath): void
    {
        try {
            $jpeg = HeicToJpg::convert($heicPath)->get();
        } catch (Throwable $exception) {
            throw new RuntimeException('Foto HEIC tidak dapat dikonversi.', previous: $exception);
        }

        if (file_put_contents($jpegPath, $jpeg) === false) {
            throw new RuntimeException('Hasil konversi HEIC tidak dapat disimpan sementara.');
        }
    }

    private function createImage(string $jpegPath): GdImage
    {
        $image = @imagecreatefromjpeg($jpegPath);

        if (! $image instanceof GdImage) {
            throw new RuntimeException('Hasil konversi HEIC tidak dapat dibaca sebagai gambar.');
        }

        return $image;
    }

    private function exifOrientation(string $jpegPath): int
    {
        $exif = @exif_read_data($jpegPath);

        return (int) ($exif['Orientation'] ?? 1);
    }

    private function orient(GdImage $image, int $orientation): GdImage
    {
        return match ($orientation) {
            2 => $this->flip($image, IMG_FLIP_HORIZONTAL),
            3 => $this->rotate($image, 180),
            4 => $this->flip($this->rotate($image, 180), IMG_FLIP_HORIZONTAL),
            5 => $this->rotate($this->flip($image, IMG_FLIP_HORIZONTAL), 90),
            6 => $this->rotate($image, -90),
            7 => $this->rotate($this->flip($image, IMG_FLIP_HORIZONTAL), -90),
            8 => $this->rotate($image, 90),
            default => $image,
        };
    }

    private function rotate(GdImage $image, int $angle): GdImage
    {
        $rotated = imagerotate($image, $angle, 0);

        if (! $rotated instanceof GdImage) {
            throw new RuntimeException('Foto hasil konversi gagal diputar.');
        }

        imagedestroy($image);

        return $rotated;
    }

    private function flip(GdImage $image, int $mode): GdImage
    {
        if (! imageflip($image, $mode)) {
            throw new RuntimeException('Foto hasil konversi gagal dibalik.');
        }

        return $image;
    }

    private function temporaryPath(string $prefix): string
    {
        $path = tempnam(sys_get_temp_dir(), $prefix);

        if ($path === false) {
            throw new RuntimeException('Tidak dapat membuat file sementara.');
        }

        return $path;
    }

    private function deleteConverterOutputs(string $heicPath): void
    {
        foreach (glob($heicPath.'-*') ?: [] as $path) {
            @unlink($path);
        }
    }
}
