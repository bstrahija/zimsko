<?php

namespace App\Models;

use App\Services\Cache;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/** @package App\Models */
class Game extends Model
{
    use HasFactory, HasSlug, HasTimestamps, SoftDeletes;

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

    protected $guarded = [];

    protected $casts = [
        'external_id'           => 'integer',
        'data'                  => 'array',
        'scheduled_at'          => 'datetime',
        'home_starting_players' => 'array',
        'away_starting_players' => 'array',
        'home_players_on_court' => 'array',
        'away_players_on_court' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
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
        return $this->belongsToMany(Player::class)->withPivot(array_merge(['event_id', 'team_id'], array_column(config('stats.columns'), 'id')));
    }

    public function homePlayers(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->where('team_id', $this->home_team_id)
            ->with('media')
            ->withPivot(array_merge(['event_id', 'team_id'], array_column(config('stats.columns'), 'id')));
    }

    public function awayPlayers(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->where('team_id', $this->away_team_id)
            ->with('media')
            ->withPivot(array_merge(['event_id', 'team_id'], array_column(config('stats.columns'), 'id')));
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

    public function referees(): BelongsToMany
    {
        return $this->belongsToMany(Official::class)->where('type', 'referee');
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

    public function regenerateSlug(): string
    {
        $slug = Str::slug($this->title);

        // Find games with the same slug
        $exists = Game::query()->where('id', '!=', $this->id)->where('slug', $slug)->first();

        if ($exists) {
            foreach (range(2, 20) as $index) {
                $slug   = Str::slug($this->title) . '-' . $index;
                $exists = Game::query()->where('id', '!=', $this->id)->where('slug', $slug)->first();

                if (! $exists) {
                    break;
                }
            }
        }

        // Update it
        $this->update(['slug' => $slug]);

        return $slug;
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
