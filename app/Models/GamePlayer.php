<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePlayer extends Model
{
    protected $table = 'game_player';

    protected $fillable = [
        'game_id',
        'player_id',
        'team_id',
        'points',
        'three_points',
        'free_throws',
        'assists',
        'rebounds',
        'blocks',
        'steals',
        'turnovers',
    ];

    protected $casts = [
        'id'           => 'integer',
        'team_id'      => 'string',
        'player_id'    => 'string',
        'game_id'      => 'string',
        'points'       => 'integer',
        'three_points' => 'integer',
        'free_throws'  => 'integer',
        'assists'      => 'integer',
        'rebounds'     => 'integer',
        'blocks'       => 'integer',
        'steals'       => 'integer',
        'turnovers'    => 'integer',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class)->orderBy('first_name');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
