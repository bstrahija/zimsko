<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Team;

trait LiveScoreStats
{
    public function addTeamStats()
    {
        if ($this->homeTeam && $this->awayTeam) {
            foreach ([$this->homeTeam, $this->awayTeam] as $team) {
                $side = $team->id === $this->homeTeam->id ? 'home' : 'away';

                $team->setStats('score',                $this->gameLive->{$side . '_score'});
                $team->setStats('misses',               $this->getTeamStat(team: $team, types: ['player_miss'], method: 'count'));
                $team->setStats('rebounds',             $this->getTeamStat(team: $team, types: ['player_rebound'], method: 'count'));
                $team->setStats('offensive_rebounds',   $this->getTeamStat(team: $team, types: ['player_rebound'], subtypes: ['off'], method: 'count'));
                $team->setStats('defensive_rebounds',   $this->getTeamStat(team: $team, types: ['player_rebound'], subtypes: ['reb', 'def'], method: 'count'));
                $team->setStats('steals',               $this->getTeamStat(team: $team, types: ['player_steal'], method: 'count'));
                $team->setStats('blocks',               $this->getTeamStat(team: $team, types: ['player_block'], method: 'count'));
                $team->setStats('turnovers',            $this->getTeamStat(team: $team, types: ['player_turnover'], method: 'count'));
                $team->setStats('assists',              $this->getTeamStat(team: $team, types: ['player_assist'], method: 'count'));
                $team->setStats('free_throws_made',     $this->getTeamStat(team: $team, types: ['player_score', 'player_score_with_assist'], subtypes: ['1pt'], method: 'count'));
                $team->setStats('free_throws_missed',   $this->getTeamStat(team: $team, types: ['player_miss'], subtypes: ['1pt'], method: 'count'));
                $team->setStats('free_throws',          $team->statsData['free_throws_made'] + $team->statsData['free_throws_missed']);
                $team->setStats('two_points_made',      $this->getTeamStat(team: $team, types: ['player_score', 'player_score_with_assist'], subtypes: ['2pt'], method: 'count'));
                $team->setStats('two_points_missed',    $this->getTeamStat(team: $team, types: ['player_miss'], subtypes: ['2pt'], method: 'count'));
                $team->setStats('two_points',           $team->statsData['two_points_made'] + $team->statsData['two_points_missed']);
                $team->setStats('three_points_made',    $this->getTeamStat(team: $team, types: ['player_score', 'player_score_with_assist'], subtypes: ['3pt'], method: 'count'));
                $team->setStats('three_points_missed',  $this->getTeamStat(team: $team, types: ['player_miss'], subtypes: ['3pt'], method: 'count'));
                $team->setStats('three_points',         $team->statsData['three_points_made'] + $team->statsData['three_points_missed']);
                $team->setStats('field_goals',          $team->statsData['two_points'] + $team->statsData['three_points']);
                $team->setStats('field_goals_made',     $team->statsData['two_points_made'] + $team->statsData['three_points_made']);
                $team->setStats('field_goals_missed',   $team->statsData['two_points_missed'] + $team->statsData['three_points_missed']);
                $team->setStats('timeouts',             $this->getTeamStat(team: $team, types: ['timeout'], subtypes: [], method: 'count'));
                $team->setStats('fouls',                $this->getTeamStat(team: $team, types: ['player_foul'], subtypes: [], method: 'count'));
                $team->setStats('personal_fouls',       $this->getTeamStat(team: $team, types: ['player_foul'], subtypes: ['pf'], method: 'count'));
                $team->setStats('technical_fouls',      $this->getTeamStat(team: $team, types: ['player_foul'], subtypes: ['tf'], method: 'count'));
                $team->setStats('flagrant_fouls',       $this->getTeamStat(team: $team, types: ['player_foul'], subtypes: ['ff'], method: 'count'));

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

                // Add period scores
                foreach (range(1, 10) as $period) {
                    $team->setStats('score_p' . $period, $this->getTeamStat(team: $team, types: ['player_score', 'player_score_with_assist'], period: $period));
                }
            }
        }
    }

    public function getTeamStat(Team $team, array $types, array $subtypes = [], $period = null, $method = 'sum'): int
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

        // And by period
        if ($period) {
            $filtered = $filtered->where('period', $period);
        }

        if ($method === 'count') {
            return $filtered->count();
        } elseif ($method === 'sum') {
            return $filtered->sum('amount');
        }

        return 0;
    }

    public function addPlayerStats()
    {
        foreach ($this->players as $player) {
            $player->setStats('score',                $this->getPlayerStat(player: $player, types: ['player_score', 'player_score_with_assist']));
            $player->setStats('misses',               $this->getPlayerStat(player: $player, types: ['player_miss'], method: 'count'));
            $player->setStats('rebounds',             $this->getPlayerStat(player: $player, types: ['player_rebound'], method: 'count'));
            $player->setStats('offensive_rebounds',   $this->getPlayerStat(player: $player, types: ['player_rebound'], subtypes: ['off'], method: 'count'));
            $player->setStats('defensive_rebounds',   $this->getPlayerStat(player: $player, types: ['player_rebound'], subtypes: ['reb', 'def'], method: 'count'));
            $player->setStats('steals',               $this->getPlayerStat(player: $player, types: ['player_steal'], method: 'count'));
            $player->setStats('blocks',               $this->getPlayerStat(player: $player, types: ['player_block'], method: 'count'));
            $player->setStats('turnovers',            $this->getPlayerStat(player: $player, types: ['player_turnover'], method: 'count'));
            $player->setStats('assists',              $this->getPlayerStat(player: $player, types: ['player_assist'], method: 'count'));
            $player->setStats('free_throws_made',     $this->getPlayerStat(player: $player, types: ['player_score', 'player_score_with_assist'], subtypes: ['1pt'], method: 'count'));
            $player->setStats('free_throws_missed',   $this->getPlayerStat(player: $player, types: ['player_miss'], subtypes: ['1pt'], method: 'count'));
            $player->setStats('free_throws',          $player->statsData['free_throws_made'] + $player->statsData['free_throws_missed']);
            $player->setStats('two_points_made',      $this->getPlayerStat(player: $player, types: ['player_score', 'player_score_with_assist'], subtypes: ['2pt'], method: 'count'));
            $player->setStats('two_points_missed',    $this->getPlayerStat(player: $player, types: ['player_miss'], subtypes: ['2pt'], method: 'count'));
            $player->setStats('two_points',           $player->statsData['two_points_made'] + $player->statsData['two_points_missed']);
            $player->setStats('three_points_made',    $this->getPlayerStat(player: $player, types: ['player_score', 'player_score_with_assist'], subtypes: ['3pt'], method: 'count'));
            $player->setStats('three_points_missed',  $this->getPlayerStat(player: $player, types: ['player_miss'], subtypes: ['3pt'], method: 'count'));
            $player->setStats('three_points',         $player->statsData['three_points_made'] + $player->statsData['three_points_missed']);
            $player->setStats('field_goals',          $player->statsData['two_points'] + $player->statsData['three_points']);
            $player->setStats('field_goals_made',     $player->statsData['two_points_made'] + $player->statsData['three_points_made']);
            $player->setStats('field_goals_missed',   $player->statsData['two_points_missed'] + $player->statsData['three_points_missed']);
            $player->setStats('timeouts',             $this->getPlayerStat(player: $player, types: ['timeout'], subtypes: [], method: 'count'));
            $player->setStats('fouls',                $this->getPlayerStat(player: $player, types: ['player_foul'], subtypes: [], method: 'count'));
            $player->setStats('personal_fouls',       $this->getPlayerStat(player: $player, types: ['player_foul'], subtypes: ['pf'], method: 'count'));
            $player->setStats('technical_fouls',      $this->getPlayerStat(player: $player, types: ['player_foul'], subtypes: ['tf'], method: 'count'));
            $player->setStats('flagrant_fouls',       $this->getPlayerStat(player: $player, types: ['player_foul'], subtypes: ['ff'], method: 'count'));

            // Calculate the efficiency
            $efficiency = 0; // ($team->stats['score'] + $team->stats['rebounds'] + $team->stats['assists'] + $team->stats['steals'] + $team->stats['blocks'] − (($team->stats['field_goals'] − $team->stats['field_goals_missed']) + ($team->stats['free_throws'] − $team->stats['free_throws_missed']) + $team->stats['turnovers']));
            $efficiency = $player->stats['score'] + $player->stats['rebounds'] + $player->stats['assists'] + $player->stats['steals'] + $player->stats['blocks'] - $player->stats['field_goals_missed'] - $player->stats['free_throws_missed'] - $player->stats['turnovers'] - $player->stats['fouls'];
            $player->setStats('efficiency', $efficiency);

            // Add period scores
            foreach (range(1, 10) as $period) {
                $player->setStats('score_p' . $period, $this->getPlayerStat(player: $player, types: ['player_score', 'player_score_with_assist'], period: $period));
            }
        }
        // die();
    }

    public function getPlayerStat(Player $player, array $types, array $subtypes = [], $period = null, $method = 'sum'): int
    {
        // First let's filter by main type
        $filtered = $this->log->where('player_id', $player->id)->filter(function ($item) use ($types) {
            return in_array($item->type, $types);
        });

        // Then by subtype
        if ($subtypes) {
            $filtered = $filtered->filter(function ($item) use ($subtypes) {
                return in_array($item->subtype, $subtypes);
            });
        }

        // And by period
        if ($period) {
            $filtered = $filtered->where('period', $period);
        }

        if ($method === 'count') {
            return $filtered->count();
        } elseif ($method === 'sum') {
            return $filtered->sum('amount');
        }

        return 0;
    }
}
