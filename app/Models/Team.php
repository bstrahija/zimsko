<?php

namespace App\Models;

use App\Services\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    use HasFactory, HasSlug, InteractsWithMedia, SoftDeletes;

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
        'id'          => 'integer',
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

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            // Clear cache when savin anything
            Cache::forgetLeaderboards();
        });
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot(['number', 'position', 'is_active']);
    }

    public function activePlayers(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot(['number', 'position', 'is_active'])->wherePivot('is_active', true);
    }

    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(Coach::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public function lastGame(): ?Game
    {
        return Game::where(fn ($query) => $query->where('home_team_id', $this->id)->orWhere('away_team_id', $this->id))
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->first();
    }

    public function nextGame(): ?Game
    {
        return Game::where(fn ($query) => $query->where('home_team_id', $this->id)->orWhere('away_team_id', $this->id))
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->first();
    }

    public function logo($size = 'thumb')
    {
        return $this->getFirstMediaUrl('logos', $size);
    }

    public function photo($size = 'thumb')
    {
        return $this->getFirstMediaUrl('photos', $size);
    }

    public function photoSize($dir = null)
    {
        if (file_exists($this->getFirstMedia('photos')?->getPath())) {
            $imageInstance = \Spatie\MediaLibrary\Support\ImageFactory::load($this->getFirstMedia('photos')?->getPath());
        } else {
            $imageInstance = null;
        }

        if ($dir === 'w') {
            return $imageInstance ? $imageInstance->getWidth() : 1280;
        } elseif ($dir === 'h') {
            return $imageInstance ? $imageInstance->getHeight() : 720;
        }

        return [
            'w' => $imageInstance ? $imageInstance->getWidth() : 1280,
            'h' => $imageInstance ? $imageInstance->getHeight() : 720,
        ];
    }

    public function stats(): Attribute
    {
        return new Attribute(
            get: fn () => $this->statsData,
        );
    }

    public function games()
    {
        return Game::where(fn ($query) => $query->where('home_team_id', $this->id)->orWhere('away_team_id', $this->id))
            ->whereNot('status', 'tmp')
            ->whereNot('status', 'archived')
            ->whereNot('status', 'draft');
    }

    public function completedGames()
    {
        return Game::where(fn ($query) => $query->where('home_team_id', $this->id)->orWhere('away_team_id', $this->id))
            ->where('status', 'completed');
    }

    public function homeGames(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames(): HasMany
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function gameCount(?Event $event = null): int
    {
        if ($event) {
            return Game::query()->where('status', 'completed')->where(fn ($query) => $query->where('home_team_id', $this->id)->orWhere('away_team_id', $this->id))->where('event_id', $event->id)->count();
        }

        return Game::query()->where('status', 'completed')->where(fn ($query) => $query->where('home_team_id', $this->id))->orWhere('away_team_id', $this->id)->count();
    }

    public function gameCountCurrent(): int
    {
        return $this->gameCount(Event::current());
    }

    public function points(?Event $event = null): int
    {
        $where = [
            'for'     => 'team',
            'type'    => $event ? 'event' : 'total',
            'team_id' => $this->id,
        ];

        if ($event) {
            $where['event_id'] = $event->id;
        }

        $stats = Stat::where($where)->first();

        return $stats ? $stats->score : 0;
    }

    public function pointsCurrent(): int
    {
        return $this->points(Event::current());
    }

    public function pointsAverage(?Event $event = null): float
    {
        $points = $this->points($event);
        $games  = $this->gameCount($event);

        return $games ? round($points / $games, 1) : 0;
    }

    public function pointsAverageCurrent(): float
    {
        return $this->pointsAverage(Event::current());
    }

    public function setStats($key, $value)
    {
        $this->statsData[$key] = $value;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logos')->singleFile();
        $this->addMediaCollection('photos')->singleFile();
        $this->addMediaCollection('backgrounds')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->performOnCollections('photos', 'backgrounds')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->performOnCollections('photos', 'backgrounds')
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

    public function latestGames($limit = 10)
    {
        return $this->games()
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function latestGamesWithStats($limit = 10)
    {
        $games = $this->latestGames($limit);

        return $games->map(fn (Game $game) => [
            'game'  => $game,
            'stats' => $game->stats()->where('for', 'team')->where('team_id', $this->id)->first(),
        ]);
    }

    public function winsAgainst(int $opponentId)
    {
        $teamId = $this->id;

        $wins = Game::where(function ($query) use ($teamId, $opponentId) {
            $query->where(function ($q) use ($teamId, $opponentId) {
                $q->where('home_team_id', $teamId)
                    ->where('away_team_id', $opponentId)
                    ->whereColumn('home_score', '>', 'away_score');
            })->orWhere(function ($q) use ($teamId, $opponentId) {
                $q->where('away_team_id', $teamId)
                    ->where('home_team_id', $opponentId)
                    ->whereColumn('away_score', '>', 'home_score');
            });
        })->where('status', 'completed')->count();

        return $wins;
    }

    public function gamesAgainst(int $opponentId)
    {
        return Game::with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])
            ->where(function ($query) use ($opponentId) {
                $query->where(function ($q) use ($opponentId) {
                    $q->where('home_team_id', $this->id)
                        ->where('away_team_id', $opponentId);
                })->orWhere(function ($q) use ($opponentId) {
                    $q->where('home_team_id', $opponentId)
                        ->where('away_team_id', $this->id);
                });
            })->orderBy('scheduled_at', 'desc')->where('status', 'completed')->get();
    }
}
