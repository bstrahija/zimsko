<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameLive extends Model
{
    use HasFactory, HasTimestamps;

    protected $table = 'games_live';

    protected $fillable = [
        'game_id',
        'home_starting_players',
        'away_starting_players',
        'home_players_on_court',
        'away_players_on_court',
        'home_players',
        'away_players',
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
        'period',
        'data',
        'status',
    ];

    protected $casts = [
        'home_players_on_court' => 'array',
        'away_players_on_court' => 'array',
        'home_starting_players' => 'array',
        'away_starting_players' => 'array',
        'home_players'          => 'array',
        'away_players'          => 'array',
        'period'                => 'integer',
        'home_score'            => 'integer',
        'away_score'            => 'integer',
        'home_score_p1'         => 'integer',
        'away_score_p1'         => 'integer',
        'home_score_p2'         => 'integer',
        'away_score_p2'         => 'integer',
        'home_score_p3'         => 'integer',
        'away_score_p3'         => 'integer',
        'home_score_p4'         => 'integer',
        'away_score_p4'         => 'integer',
        'home_score_p5'         => 'integer',
        'away_score_p5'         => 'integer',
        'home_score_p6'         => 'integer',
        'away_score_p6'         => 'integer',
        'home_score_p7'         => 'integer',
        'away_score_p7'         => 'integer',
        'home_score_p8'         => 'integer',
        'away_score_p8'         => 'integer',
        'home_score_p9'         => 'integer',
        'away_score_p9'         => 'integer',
        'home_score_p10'        => 'integer',
        'away_score_p10'        => 'integer',
        'data'                  => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class, 'game_id');
    }

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
