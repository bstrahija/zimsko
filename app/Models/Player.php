<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
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

class Player extends Model implements HasMedia
{
    use HasFactory, HasSlug, HasUlids, SoftDeletes, InteractsWithMedia;

    const POSITION_OPTIONS = [
        'point-guard'     => 'Point Guard',
        'shooting-guard'  => 'Shooting Guard',
        'small-forward'   => 'Small Forward',
        'power-forward'   => 'Power Forward',
        'center'          => 'Center',
    ];

    public $statsData = [
        'games'            => 0,
        'points'           => 0,
        'misses'           => 0,
        'three_points'     => 0,
        'avg'              => 0,
        'avg_three_points' => 0,
        'efficiency'       => 0,      // (PTS + REB + AST + STL + BLK − ((FGA − FGM) + (FTA − FTM) + TO))
        'fouls'            => 0,
        'team'             => null,
        'timeouts'         => 0,
        'rebounds'         => 0,
        'blocks'           => 0,
        'assists'          => 0,
        'turnovers'        => 0,
        'blocks'           => 0,
        'steals'           => 0,
    ];

    protected $fillable = [
        'name',
        'slug',
        'number',
        'position',
        'height',
        'weight',
        'birthday',
        'data',
        'external_id',
    ];

    protected $casts = [
        'id'          => 'string',
        'external_id' => 'integer',
        'birthday'    => 'date',
        'data'        => 'array',
    ];

    protected $appends = ['stats'];

    public static function findByTeamAndNumber($teamId, $number)
    {
        $team = Team::with('players')->find($teamId);


        return $team->players()->where('number', $number)->first();
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function photo($size = 'thumb')
    {
        return $this->getFirstMediaUrl('photos', $size);
    }

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

    public function stats(): Attribute
    {
        return new Attribute(
            get: fn() => $this->statsData,
        );
    }

    public function setStats($key, $value)
    {
        $this->statsData[$key] = $value;
    }
}
