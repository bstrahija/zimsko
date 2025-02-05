<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Stats
{
    use StatsPlayers, StatsTeams;

    /**
     * Calculate efficiency rating by specific formula
     *
     * @param array $data
     * @return int|float
     */
    public static function calculateEfficiency(array $data)
    {
        // Check for missing data
        if (!isset($data['field_goals_missed'])) {
            $data['field_goals_missed'] = $data['field_goals'] - $data['field_goals_made'];
        }
        if (!isset($data['free_throws_missed'])) {
            $data['free_throws_missed'] = $data['free_throws'] - $data['free_throws_made'];
        }

        $efficiency = $data['score']
            + $data['rebounds']
            + $data['assists']
            + $data['steals']
            + $data['blocks']
            - $data['field_goals_missed']
            - $data['free_throws_missed']
            - $data['turnovers']
            - $data['fouls']
            - $data['score_against'];

        return $efficiency;
    }
}
