<?php

namespace App\Models;

use App\Services\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    public static $currentEvent;

    public static $lastEvent;

    protected $fillable = [
        'title',
        'slug',
        'body',
    ];

    protected $casts = [
        'external_id'  => 'integer',
        'data'         => 'array',
        'scheduled_at' => 'timestamp',
    ];

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->BelongsToMany(Team::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public static function current(array $with = []): ?Event
    {
        if (! static::$currentEvent) {
            $settingsEventId      = Settings::get('general.current_event_id', null);
            static::$currentEvent = $settingsEventId ? Event::with($with)->find($settingsEventId) : Event::last();
        }

        return static::$currentEvent;
    }

    public static function last(): ?Event
    {
        if (! static::$lastEvent) {
            static::$lastEvent = Event::orderBy('scheduled_at', 'desc')->first();
        }

        return static::$lastEvent;
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

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
