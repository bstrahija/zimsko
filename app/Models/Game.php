<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/** @package App\Models */
class Game extends Model
{
    use HasFactory, HasSlug, HasUlids, HasTimestamps, SoftDeletes;

    protected $keyType = 'string';

    const STATUS_OPTIONS = [
        'draft'       => 'Draft',
        'scheduled'   => 'Scheduled',
        'in_progress' => 'In Progress',
        'completed'   => 'Completed',
    ];

    const TYPE_OPTIONS = [
        'regular'       => 'Regular',
        'quarter_final' => 'Quarter Final',
        'semi_final'    => 'Semi Final',
        'final'         => 'Final',
        'playoff'       => 'Playoff',
        'exhibition'    => 'Exhibition',
    ];

    protected $fillable = [
        'title',
        'slug',
        'body',
        'event_id',
        'round_id',
        'home_team_id',
        'away_team_id',
        'data',
        'status',
        'type',
        'external_id',
        'created_at',
        'updated_at',
        'home_score',
        'away_score',
        'home_score_p1',
        'away_score_p1',
        'home_score_p2',
        'away_score_p2',
        'home_score_p3',
        'away_score_p3',
        'home_score_p4',
        'away_score_p4',
        'home_score_p5',
        'away_score_p5',
        'home_score_p6',
        'away_score_p6',
        'home_score_p7',
        'away_score_p7',
        'home_score_p8',
        'away_score_p8',
        'home_score_p9',
        'away_score_p9',
        'home_score_p10',
        'away_score_p10',
        'scheduled_at',
    ];

    protected $casts = [
        'id'           => 'string',
        'external_id'  => 'integer',
        'event_id'     => 'string',
        'round_id'     => 'integer',
        'home_team_id' => 'string',
        'away_team_id' => 'string',
        'data'         => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function live(): HasOne
    {
        return $this->hasOne(GameLive::class);
    }

    public function gameLogs(): HasMany
    {
        return $this->hasMany(GameLog::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot(config('stats.columns'));
    }

    public function homePlayers(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->where('team_id', $this->home_team_id)
            ->with('media')
            ->withPivot(config('stats.columns'));
    }

    public function awayPlayers(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->where('team_id', $this->away_team_id)
            ->with('media')
            ->withPivot(config('stats.columns'));
    }

    public function gamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class);
    }

    public function homeGamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class)->where('team_id', $this->home_team_id);
    }

    public function awayGamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class)->where('team_id', $this->away_team_id);
    }

    public function referees(): HasMany
    {
        return $this->hasMany(Referee::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isDraw(): bool
    {
        return $this->home_score === $this->away_score;
    }

    public function winner(): ?Team
    {
        return $this->home_score > $this->away_score ? $this->homeTeam : $this->awayTeam;
    }

    public function loser(): ?Team
    {
        return $this->home_score < $this->away_score ? $this->homeTeam : $this->awayTeam;
    }

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class);
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
