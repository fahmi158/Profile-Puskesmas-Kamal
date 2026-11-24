<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;
use Throwable;

class WebpFileUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mimeTypeMap([
            'heic' => 'image/heic',
            'heif' => 'image/heif',
        ]);

        $this->saveUploadedFileUsing(function (WebpFileUpload $component, TemporaryUploadedFile $file): ?string {
            if (! $component->isHeic($file)) {
                return $component->saveUploadedFile($file);
            }

            try {
                return $component->storeHeicAsWebp($file);
            } catch (Throwable $exception) {
                report($exception);

                throw ValidationException::withMessages([
                    $component->getStatePath() => 'Foto HEIC gagal dikonversi ke WebP. Silakan coba lagi atau gunakan format JPG/PNG.',
                ]);
            }
        });
    }

    public function image(): static
    {
        $this->acceptedFileTypes([
            'image/*',
            'image/heic',
            'image/heif',
        ]);

        return $this;
    }

    public function isHeic(TemporaryUploadedFile $file): bool
    {
        if (in_array(strtolower($file->getClientOriginalExtension()), ['heic', 'heif'], true)) {
            return true;
        }

        return in_array(strtolower((string) $file->getMimeType()), [
            'image/heic',
            'image/heif',
            'image/heic-sequence',
            'image/heif-sequence',
        ], true);
    }

    public function storeHeicAsWebp(TemporaryUploadedFile $file): string
    {
        $sourcePath = $this->copyToTemporaryHeic($file);

        try {
            $contents = app(HeicToWebpConverter::class)->convert($sourcePath);
        } finally {
            @unlink($sourcePath);
        }

        return $this->storeWebpContents($file, $contents);
    }

    private function copyToTemporaryHeic(TemporaryUploadedFile $file): string
    {
        $path = tempnam(sys_get_temp_dir(), 'heic-source');

        if ($path === false) {
            throw new RuntimeException('Tidak dapat membuat file sementara untuk foto HEIC.');
        }

        $target = $path.'.heic';

        if (! rename($path, $target)) {
            @unlink($path);

            throw new RuntimeException('Tidak dapat menyiapkan file sementara untuk foto HEIC.');
        }

        if (! copy($file->getRealPath(), $target)) {
            @unlink($target);

            throw new RuntimeException('Tidak dapat menyalin foto HEIC ke file sementara.');
        }

        return $target;
    }

    private function storeWebpContents(TemporaryUploadedFile $file, string $contents): string
    {
        $fileName = pathinfo($this->getUploadedFileNameForStorage($file), PATHINFO_FILENAME).'.webp';
        $directory = trim((string) $this->getDirectory(), '/');
        $path = ltrim($directory.'/'.$fileName, '/');

        if (! $this->getDisk()->put($path, $contents)) {
            throw new RuntimeException('Foto WebP hasil konversi gagal disimpan.');
        }

        if ($this->getVisibility() === 'public') {
            rescue(fn () => $this->getDisk()->setVisibility($path, 'public'), report: false);
        }

        return $path;
    }
}
