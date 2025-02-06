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
