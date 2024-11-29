<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLive extends Model
{
    use HasFactory, HasUlids, HasTimestamps;

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
        'home_score_q1',
        'away_score_q1',
        'home_score_q2',
        'away_score_q2',
        'home_score_q3',
        'away_score_q3',
        'home_score_q4',
        'away_score_q4',
        'home_score_q5',
        'away_score_q5',
        'home_score_q6',
        'away_score_q6',
        'quarter',
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
        'quarter'               => 'integer',
        'home_score'            => 'integer',
        'away_score'            => 'integer',
        'home_score_q1'         => 'integer',
        'away_score_q1'         => 'integer',
        'home_score_q2'         => 'integer',
        'away_score_q2'         => 'integer',
        'home_score_q3'         => 'integer',
        'away_score_q3'         => 'integer',
        'home_score_q4'         => 'integer',
        'away_score_q4'         => 'integer',
        'home_score_q5'         => 'integer',
        'away_score_q5'         => 'integer',
        'home_score_q6'         => 'integer',
        'away_score_q6'         => 'integer',
        'data'                  => 'array',
    ];
}
