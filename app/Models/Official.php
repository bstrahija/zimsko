<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Official extends Model implements HasMedia
{
    use HasFactory, HasSlug, SoftDeletes, InteractsWithMedia;

    protected const TYPE_OPTIONS = [
        'organizer',
        'referee',
        'developer',
        'photographer',
        'official',
    ];

    protected $fillable = [
        'name',
        'slug',
        'body',
        'type',
        'birthday',
        'status',
        'data',
    ];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public function scopeReferees(Builder $query): void
    {
        $query->where('type', 'referee');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')->singleFile();
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
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
