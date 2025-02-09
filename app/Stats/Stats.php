<?php

namespace App\Stats;

class Stats
{
    use StatsPlayers, StatsTeams, StatsForLeaderboards, StatsForLogs;

    /**
     * Calculate efficiency rating by specific formula
     *
     * @param array $data
     * @return int|float
     */
    public static function calculateEfficiency(array $data)
    {
        $gameCount = isset($data['games']) ? $data['games'] : 1;
        if ($gameCount < 1) $gameCount = 1;

        // Check for missing data
        if (!isset($data['field_goals_missed'])) {
            $data['field_goals_missed'] = $data['field_goals'] - $data['field_goals_made'];
        }
        if (!isset($data['free_throws_missed'])) {
            $data['free_throws_missed'] = $data['free_throws'] - $data['free_throws_made'];
        }

        $efficiency = round(($data['score']
            + $data['rebounds']
            + $data['assists']
            + $data['steals']
            + $data['blocks']
            - $data['field_goals_missed']
            - $data['free_throws_missed']
            - $data['turnovers']
            - $data['fouls']
            - $data['score_against']) / $gameCount, 1);

        return $efficiency;
    }
}
