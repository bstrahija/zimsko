<?php

namespace App\Models;

use App\Services\Settings;
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

    public static function current(): ?Event
    {
        $settingsEventId = Settings::get('general.current_event_id', null);
        $event           = $settingsEventId ? Event::find($settingsEventId) : Event::last();

        return $event;
    }

    public static function last(): ?Event
    {
        return Event::orderBy('scheduled_at', 'desc')->first();
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
