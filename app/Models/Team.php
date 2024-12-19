<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'games'                   => 0,
        'wins'                    => 0,
        'losses'                  => 0,
        'points'                  => 0, // This is not the score, it's leaderboard points
        'score'                   => 0,
        'misses'                  => 0,
        'free_throws'             => 0,
        'free_throws_made'        => 0,
        'free_throws_missed'      => 0,
        'free_throws_percent'     => 0,
        'two_points'              => 0,
        'two_points_made'         => 0,
        'two_points_missed'       => 0,
        'two_points_percent'      => 0,
        'three_points'            => 0,
        'three_points_made'       => 0,
        'three_points_missed'     => 0,
        'three_points_percent'    => 0,
        'field_goals'             => 0,
        'field_goals_made'        => 0,
        'field_goals_missed'      => 0,
        'field_goals_percent'     => 0,
        'opponent_score'          => 0,
        'efficiency'              => 0,   // (PTS + REB + AST + STL + BLK − ((FGA − FGM) + (FTA − FTM) + TO))
        'fouls'                   => 0,
        'personal_fouls'          => 0,
        'flagrant_fouls'          => 0,
        'current_period_fouls'    => 0,
        'technical_fouls'         => 0,
        'timeouts'                => 0,
        'current_period_timeouts' => 0,
        'rebounds'                => 0,
        'offensive_rebounds'      => 0,
        'defensive_rebounds'      => 0,
        'assists'                 => 0,
        'turnovers'               => 0,
        'blocks'                  => 0,
        'steals'                  => 0,
        'score_p1'                => 0,
        'score_p2'                => 0,
        'score_p3'                => 0,
        'score_p4'                => 0,
        'score_p5'                => 0,
        'score_p6'                => 0,
        'score_p7'                => 0,
        'score_p8'                => 0,
        'score_p9'                => 0,
        'score_p10'               => 0,
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

    protected $appends = ['stats'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function players(): BelongsToMany
    {
        return $this->BelongsToMany(Player::class)->withPivot(['number', 'position']);
    }

    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class);
    }

    public function logo($size = 'thumb')
    {
        return $this->getFirstMediaUrl('logos', $size);
    }

    public function stats(): Attribute
    {
        return new Attribute(
            get: fn() => $this->statsData,
        );
    }

    public function homeGames(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames(): HasMany
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function setStats($key, $value)
    {
        $this->statsData[$key] = $value;
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
