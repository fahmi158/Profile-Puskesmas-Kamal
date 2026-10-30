<?php

namespace App\Models;

use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'youtube_url',
        'thumbnail',
        'published_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function getYoutubeIdAttribute(): ?string
    {
        return $this->extractYoutubeId($this->youtube_url);
    }

    protected function extractYoutubeId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $patterns = [
            '/youtube\.com\/watch\?v=([A-Za-z0-9_-]{11})/',
            '/youtu\.be\/([A-Za-z0-9_-]{11})/',
            '/youtube\.com\/embed\/([A-Za-z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([A-Za-z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
