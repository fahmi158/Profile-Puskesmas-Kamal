<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Feedback;
use App\Models\News;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Berita & Artikel', News::query()->count())
                ->description('Total konten terbit')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
            Stat::make('Agenda', Event::query()->count())
                ->description('Total agenda kegiatan')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Layanan Aktif', Service::query()->where('status', 'published')->count())
                ->description('Layanan yang tayang')
                ->descriptionIcon('heroicon-m-heart')
                ->color('primary'),
            Stat::make('Pesan Belum Dibaca', Feedback::query()->where('is_read', false)->count())
                ->description('Umpan balik dari masyarakat')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
        ];
    }
}
