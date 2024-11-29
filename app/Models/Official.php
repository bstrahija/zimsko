<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Official extends Model
{
    use HasSlug, HasUlids, InteractsWithMedia;

    protected const POSITION_OPTIONS = [
        'organizer',
        'developer',
        'photographer',
        'official',
    ];

    protected $fillable = [
        'name',
        'slug',
        'body',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 600, 600)
            ->nonQueued();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
