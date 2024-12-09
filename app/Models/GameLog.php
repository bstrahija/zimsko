<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLog extends Model
{
    use HasFactory, HasUlids, HasTimestamps;

    protected $table = 'games_log';

    protected $fillable = [
        'game_id',
        'game_live_id',
        'period',
        'player_id',
        'player_2_id',
        'player_name',
        'player_2_name',
        'team_name',
        'team_side',
        'home_score',
        'away_score',
        'team_id',
        'coach_id',
        'referee_id',
        'official_id',
        'type',
        'subtype',
        'amount',
        'summary',
        'data',
        'occurred_at',
        'occurred_at_p',
    ];

    protected $casts = [
        'player_id'   => 'integer',
        'player_2_id' => 'integer',
        'team_id'     => 'integer',
        'coach_id'    => 'integer',
        'referee_id'  => 'integer',
        'official_id' => 'integer',
        'home_score'  => 'integer',
        'away_score'  => 'integer',
        'amount'      => 'integer',
        'period'      => 'integer',
        'data'        => 'array'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function gameLive(): BelongsTo
    {
        return $this->belongsTo(GameLive::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function referee(): BelongsTo
    {
        return $this->belongsTo(Referee::class);
    }

    public function official(): BelongsTo
    {
        return $this->belongsTo(Official::class);
    }
}
