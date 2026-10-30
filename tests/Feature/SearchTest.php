<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_loads_without_query(): void
    {
        $this->get(route('search'))->assertOk();
    }

    public function test_search_finds_matching_news(): void
    {
        $news = News::factory()->create([
            'title' => 'Posyandu Balita Digelar',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('search', ['q' => 'Posyandu']))
            ->assertOk()
            ->assertSee($news->title);
    }

    public function test_search_finds_matching_services(): void
    {
        $service = Service::factory()->create([
            'name' => 'Poli Gigi Spesial',
            'status' => 'published',
        ]);

        $this->get(route('search', ['q' => 'Gigi']))
            ->assertOk()
            ->assertSee($service->name);
    }

    public function test_search_without_results_shows_empty_state(): void
    {
        $this->get(route('search', ['q' => 'kata-yang-tidak-ada-xyz']))
            ->assertOk()
            ->assertSee('Tidak ada hasil', false);
    }
}
