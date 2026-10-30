<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Document;
use App\Models\Event;
use App\Models\News;
use App\Models\Page;
use App\Models\Service;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_static_pages_load(): void
    {
        foreach (['/profil', '/layanan', '/jadwal', '/berita', '/agenda', '/dokumentasi', '/video', '/dokumen', '/faq', '/kontak'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_profile_page_detail_loads(): void
    {
        Page::factory()->create(['slug' => 'sejarah', 'title' => 'Sejarah Kami']);

        $this->get(route('profil.sejarah'))->assertOk()->assertSee('Sejarah Kami');
    }

    public function test_unknown_page_returns_404(): void
    {
        $this->get(route('pages.show', 'tidak-ada'))->assertNotFound();
    }

    public function test_news_index_and_detail_load(): void
    {
        $news = News::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('news.index'))->assertOk()->assertSee($news->title);
        $this->get(route('news.show', $news->slug))->assertOk()->assertSee($news->title);
    }

    public function test_news_detail_returns_404_for_unknown_slug(): void
    {
        $this->get(route('news.show', 'entah-apa'))->assertNotFound();
    }

    public function test_event_index_and_detail_load(): void
    {
        $event = Event::factory()->create(['status' => 'published']);

        $this->get(route('events.index'))->assertOk()->assertSee($event->title);
        $this->get(route('events.show', $event->slug))->assertOk()->assertSee($event->title);
    }

    public function test_album_index_and_detail_load(): void
    {
        $album = Album::factory()->create(['status' => 'published']);

        $this->get(route('albums.index'))->assertOk()->assertSee($album->title);
        $this->get(route('albums.show', $album->slug))->assertOk()->assertSee($album->title);
    }

    public function test_video_index_and_detail_load(): void
    {
        $video = Video::factory()->create(['status' => 'published']);

        $this->get(route('videos.index'))->assertOk()->assertSee($video->title);
        $this->get(route('videos.show', $video->slug))->assertOk()->assertSee($video->title);
    }

    public function test_service_index_and_detail_load(): void
    {
        $service = Service::factory()->create(['status' => 'published']);

        $this->get(route('services.index'))->assertOk()->assertSee($service->name);
        $this->get(route('services.show', $service->slug))->assertOk()->assertSee($service->name);
    }

    public function test_document_index_loads(): void
    {
        $document = Document::factory()->create(['status' => 'published']);

        $this->get(route('documents.index'))->assertOk()->assertSee($document->title);
    }

    public function test_schedule_index_loads(): void
    {
        $this->get(route('schedules.index'))->assertOk();
    }

    public function test_draft_content_is_not_public(): void
    {
        $draft = News::factory()->create(['status' => 'draft', 'published_at' => null]);

        $this->get(route('news.index'))->assertOk()->assertDontSee($draft->title);
    }
}
