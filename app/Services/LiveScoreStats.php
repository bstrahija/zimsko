<?php

namespace App\Services;

use App\Models\Team;

trait LiveScoreStats
{
    public function addTeamStats()
    {
        foreach ([$this->homeTeam, $this->awayTeam] as $team) {
            $side = $team->id === $this->homeTeam->id ? 'home' : 'away';

            $team->setStats('score',                $this->gameLive->{$side . '_score'});
            $team->setStats('misses',               $this->getTeamStat($team, ['player_miss']), 'count');
            $team->setStats('fouls',                $this->getTeamStat($team, ['player_foul']), 'count');
            $team->setStats('rebounds',             $this->getTeamStat($team, ['player_rebound']), 'count');
            $team->setStats('offensive_rebounds',   $this->getTeamStat($team, ['player_rebound'], ['off']), 'count');
            $team->setStats('defensive_rebounds',   $this->getTeamStat($team, ['player_rebound'], ['reb', 'def']), 'count');
            $team->setStats('steals',               $this->getTeamStat($team, ['player_steal']), 'count');
            $team->setStats('blocks',               $this->getTeamStat($team, ['player_block']), 'count');
            $team->setStats('turnovers',            $this->getTeamStat($team, ['player_turnover']), 'count');
            $team->setStats('assists',              $this->getTeamStat($team, ['player_assist']), 'count');
            $team->setStats('free_throws_made',     $this->getTeamStat($team, ['player_score', 'player_score_with_assist'], ['1pt'], 'count'));
            $team->setStats('free_throws_missed',   $this->getTeamStat($team, ['player_miss'], ['1pt'], 'count'));
            $team->setStats('free_throws',          $team->statsData['free_throws_made'] + $team->statsData['free_throws_missed']);
            $team->setStats('free_throws_percent',  $team->statsData['free_throws'] ? round(($team->statsData['free_throws_made'] / $team->statsData['free_throws']) * 100, 2) : 0);
            $team->setStats('two_points_made',      $this->getTeamStat($team, ['player_score', 'player_score_with_assist'], ['2pt'], 'count'));
            $team->setStats('two_points_missed',    $this->getTeamStat($team, ['player_miss'], ['2pt'], 'count'));
            $team->setStats('two_points',           $team->statsData['two_points_made'] + $team->statsData['two_points_missed']);
            $team->setStats('two_points_percent',   $team->statsData['two_points'] ? round(($team->statsData['two_points_made'] / $team->statsData['two_points']) * 100, 2) : 0);
            $team->setStats('three_points_made',    $this->getTeamStat($team, ['player_score', 'player_score_with_assist'], ['3pt'], 'count'));
            $team->setStats('three_points_missed',  $this->getTeamStat($team, ['player_miss'], ['3pt'], 'count'));
            $team->setStats('three_points',         $team->statsData['three_points_made'] + $team->statsData['three_points_missed']);
            $team->setStats('three_points_percent', $team->statsData['three_points'] ? round(($team->statsData['three_points_made'] / $team->statsData['three_points']) * 100, 2) : 0);
            $team->setStats('timeouts',             $this->getTeamStat($team, ['timeout'], [], 'count'));
            $team->setStats('fouls',               $this->getTeamStat($team, ['player_foul'], [], 'count'));
            // dump($team->statsData);
            // dump((int) $team->statsData['score']);
            // echo '<pre>';
            // print_r($team->statsData);
            // print_r("===");
            // echo '</pre>';

            // TODO: Add fouls for current quarter
            $team->setStats('current_period_fouls', $this->log->where('team_id', $team->id)->where('period', $this->currentPeriod)->filter(function ($item) {
                return $item->type === 'player_foul';
            })->count());

            // TODO: Also add timeouts for current quarter
            $team->setStats('current_period_timeouts', $this->log->where('team_id', $team->id)->where('period', $this->currentPeriod)->filter(function ($item) {
                return $item->type === 'timeout';
            })->count());

            // dd((int) $team->stats['score']);

            // Calculate the efficiency
            $efficiency = 0; // ($team->stats['score'] + $team->stats['rebounds'] + $team->stats['assists'] + $team->stats['steals'] + $team->stats['blocks'] − (($team->stats['field_goals'] − $team->stats['field_goals_missed']) + ($team->stats['free_throws'] − $team->stats['free_throws_missed']) + $team->stats['turnovers']));
            $efficiency = $team->stats['score'] + $team->stats['rebounds'] + $team->stats['assists'] + $team->stats['steals'] + $team->stats['blocks'] - $team->stats['field_goals_missed'] - $team->stats['free_throws_missed'] - $team->stats['turnovers'] - $team->stats['fouls'];
            $team->setStats('efficiency', $efficiency);
        }
    }

    public function getTeamStat(Team $team, array $types, array $subtypes = [], $method = 'sum'): int
    {
        // First let's filter by main type
        $filtered = $this->log->where('team_id', $team->id)->filter(function ($item) use ($types) {
            return in_array($item->type, $types);
        });

        // Then by subtype
        if ($subtypes) {
            $filtered = $filtered->filter(function ($item) use ($subtypes) {
                return in_array($item->subtype, $subtypes);
            });
        }

        if ($method === 'count') {
            return $filtered->count();
        } elseif ($method === 'sum') {
            return $filtered->sum('amount');
        }

        return 0;
    }
}
