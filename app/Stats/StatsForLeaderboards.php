<?php

namespace App\Stats;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait StatsForLeaderboards
{
    public static function teamEventStats($teamId = null, $limit = 20): array
    {
        $stats = Stat::with(['team', 'team.media'])->where('for', 'team')->where('type', 'event')->where('event_id', Event::current()->id);

        if ($teamId) {
            $stats = $stats->where('team_id', $teamId)->first();
        } else {
            $stats = $stats->get();
        }

        return $teamId ?
            self::optimizeTeamDataItemForLeaderboards($stats) :
            self::optimizeTeamDataForLeaderboards($stats);
    }

    public static function teamPlayerEventStats($teamId)
    {
        // Get the team
        $team = Team::with(['activePlayers', 'activePlayers.media'])->find($teamId);

        $stats = Stat::where('for', 'player')
            ->with(['player', 'player.media'])
            ->where('type', 'event')
            ->where('event_id', Event::current()->id)
            ->where('team_id', $teamId)
            ->get();

        // Add player data
        foreach ($team->players as $player) {
            foreach ($stats as $stat) {
                if ($stat->player_id == $player->id) {
                    $stat->player = $player;
                }
            }
        }

        return self::optimizePlayerDataForLeaderboards($stats, 'all');
    }

    public static function playerEventStats($playerId = null, $limit = 20): array
    {
        $stats = [
            'score'        => self::playerEventStatsSingle('score',        'score',               'desc', 20),
            'three_points' => self::playerEventStatsSingle('three_points', 'three_points_made',   'desc', 20),
            'field_goals'  => self::playerEventStatsSingle('field_goals',  'field_goals_percent', 'desc', 20), //self::playerEventFieldGoals($limit),
            'free_throws'  => self::playerEventStatsSingle('free_throws',  'free_throws_percent', 'desc', 20),
            'assists'      => self::playerEventStatsSingle('assists',      'assists',             'desc', 20), //self::playerEventAssists($limit),
            'rebounds'     => self::playerEventStatsSingle('rebounds',     'rebounds',            'desc', 20), //self::playerEventRebounds($limit),
            'blocks'       => self::playerEventStatsSingle('blocks',       'blocks',              'desc', 20),
            'steals'       => self::playerEventStatsSingle('steals',       'steals',              'desc', 20),
            'fouls'        => self::playerEventStatsSingle('fouls',        'fouls',               'desc', 20),
            'turnovers'    => self::playerEventStatsSingle('turnovers',    'turnovers',           'desc', 20),
            'efficiency'   => self::playerEventStatsSingle('efficiency',   'efficiency',           'desc', 20),
        ];

        return $stats;
    }

    public static function playerEventStatsSingle($type, $column, $order = 'desc', $limit = 20)
    {
        $stats = Stat::with(['player', 'player.media'])
            ->where('for', 'player')
            ->where('type', 'event')
            ->where('event_id', Event::current()->id)
            ->take($limit)
            ->orderBy($column, $order)
            ->get();

        return self::optimizePlayerDataForLeaderboards($stats, $type);
    }

    protected static function optimizeTeamDataForLeaderboards(Collection $data): array
    {
        $optimizedData = [];

        foreach ($data as $item) {
            $optimizedItem = self::optimizeTeamDataItemForLeaderboards($item);

            // Push it
            $optimizedData[] = $optimizedItem;
        }

        return $optimizedData;
    }

    public static function optimizeTeamDataItemForLeaderboards($item): array
    {
        $optimizedItem = $item->toArray();

        // Add stuff
        $optimizedItem['team_title'] = $item->team->title;
        $optimizedItem['team_logo']  = $item->team->logo();
        $optimizedItem['team_slug']  = $item->team->slug;

        // Remove stuff
        unset($optimizedItem['team']);

        return $optimizedItem;
    }

    protected static function optimizePlayerDataForLeaderboards(Collection $data, $type = 'score'): array
    {
        $optimizedData = [];

        foreach ($data as $item) {
            $optimizedItem = self::optimizePlayerDataItemForLeaderboards($item, $type);

            // Push it
            $optimizedData[] = $optimizedItem;
        }

        return $optimizedData;
    }

    public static function optimizePlayerDataItemForLeaderboards($item, $type = 'score'): array
    {
        $optimizedItem = $item->toArray();

        if (! is_array($optimizedItem['player'])) {
            $optimizedItem['player'] = $optimizedItem['player']->toArray();
        }

        // Add stuff
        $optimizedItem['team_id']         = $item->team_id;
        $optimizedItem['player_name']     = $item->player->name;
        $optimizedItem['player_number']   = $item->player->number;
        $optimizedItem['player_position'] = $item->player->position;
        $optimizedItem['player_slug']     = $item->player->slug;
        $optimizedItem['player_photo']    = $item->player->photo();

        // Remove stuff
        unset($optimizedItem['player']);
        if ($type !== 'all') {
            $optimizedItem = Arr::only($optimizedItem, [
                'id',
                'team_id',
                'player_photo',
                'player_name',
                'player_number',
                'player_position',
                'player_slug',
                $type,
                $type . '_made',
                $type . '_percent',
                'field_goals_percent',
                'offensive_rebounds',
                'defensive_rebounds',
            ]);
        } else {
            $optimizedItem = $optimizedItem;
        }

        return $optimizedItem;
    }
}
