<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Team extends Model implements HasMedia
{
    use HasFactory, HasSlug, HasUlids, InteractsWithMedia, SoftDeletes;

    protected $keyType = 'string';

    public $statsData = [
        'games'          => 0,
        'wins'           => 0,
        'losses'         => 0,
        'score'          => 0,
        'opponent_score' => 0,
        'points'         => 0,
    ];

    protected $casts = [
        'id'          => 'string',
        'external_id' => 'integer',
        'data'        => 'object',
    ];

    protected $fillable = [
        'external_id',
        'title',
        'short_title',
        'slug',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function players(): BelongsToMany
    {
        return $this->BelongsToMany(Player::class);
    }

    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class);
    }

    public function logo($size = 'thumb')
    {
        return $this->getFirstMediaUrl('logos', $size);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logos');
        $this->addMediaCollection('photos');
        $this->addMediaCollection('backgrounds');
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
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
