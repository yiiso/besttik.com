<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'category_id',
        'status',
        'published_at',
        'views',
        'reading_time',
        'tags'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFormattedPublishedAtAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('M j, Y') : '';
    }

    public function getReadingTimeTextAttribute(): string
    {
        return $this->reading_time . ' min read';
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
