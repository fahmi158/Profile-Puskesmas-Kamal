<?php

namespace Tests\Feature;

use App\Filament\Resources\News\Pages\CreateNews;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HeicUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_heic_thumbnail_is_stored_as_webp(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create());

        $source = base_path('vendor/maestroerror/php-heic-to-jpg/image1.heic');

        $this->assertFileExists($source);

        Livewire::test(CreateNews::class)
            ->fillForm([
                'title' => 'Berita HEIC',
                'slug' => 'berita-heic',
                'content' => '<p>Isi berita.</p>',
                'status' => 'draft',
                'thumbnail' => UploadedFile::fake()->createWithContent(
                    'foto.heic',
                    file_get_contents($source),
                ),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $news = News::query()->firstOrFail();

        $this->assertStringEndsWith('.webp', $news->thumbnail);
        Storage::disk('public')->assertExists($news->thumbnail);

        $contents = Storage::disk('public')->get($news->thumbnail);

        $this->assertSame('RIFF', substr($contents, 0, 4));
        $this->assertSame('WEBP', substr($contents, 8, 4));
    }
}
