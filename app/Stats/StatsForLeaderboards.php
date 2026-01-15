<?php

namespace App\Stats;

use App\Models\Event;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait StatsForLeaderboards
{
    public static function teamEventStats($teamId = null, $limit = 20, ?int $eventId = null): array
    {
        // When no eventId, use 'total' stats; otherwise use 'event' stats for specific event
        $statsType = $eventId ? 'event' : 'total';

        $query = Stat::with(['team', 'team.media'])->where('for', 'team')->where('type', $statsType);

        if ($eventId) {
            $query->where('event_id', $eventId);
        }

        if ($teamId) {
            $stats = $query->where('team_id', $teamId)->first();
        } else {
            $stats = $query->get();

            // If we get no stats at all, we need to return a list of teams with empty stats
            if (! $stats || ! $stats->count()) {
                if ($eventId) {
                    $event = Event::find($eventId);
                    $teams = $event->teams;
                } else {
                    $teams = \App\Models\Team::all();
                }

                foreach ($teams as $team) {
                    $emptyStat           = Stat::empty();
                    $emptyStat->team_id  = $team->id;
                    $emptyStat->team     = $team;
                    $emptyStat->event_id = $eventId;
                    $emptyStat->for      = 'team';
                    $emptyStat->type     = $statsType;
                    $emptyStat->games    = 0;

                    $stats->push($emptyStat);
                }
            }
        }

        return $teamId ?
            self::optimizeTeamDataItemForLeaderboards($stats) :
            self::optimizeTeamDataForLeaderboards($stats);
    }

    public static function teamPlayerEventStats(int $teamId, ?int $eventId = null): array
    {
        // Lets create an empty stat for missing players
        $emptyStat = Stat::empty();

        // Get the team
        $team = Team::with(['activePlayers', 'activePlayers.media'])->find($teamId);

        // Since players can change teams between events, we first need to get all current players for the selected team
        $players = $team->players()->select('id')->pluck('id')->toArray();

        if ($eventId) {
            $stats = Stat::where('for', 'player')
                ->with(['player', 'player.media'])
                ->where('type', 'event')
                ->where('event_id', $eventId)
                ->whereIn('player_id', $players)
                ->get();
        } else {
            $stats = Stat::where('for', 'player')
                ->with(['player', 'player.media'])
                ->where('type', 'total')
                ->whereIn('player_id', $players)
                ->get();
        }

        // Add player data
        $allStats = collect([]);
        foreach ($team->players as $player) {
            // Now let's find the stats for this player
            $playerStats = null;

            foreach ($stats as $stat) {
                if ($stat->player_id == $player->id) {
                    $playerStats         = $stat;
                    $playerStats->player = $player;
                }
            }

            // When no stats found, create empty one
            if (! $playerStats) {
                $playerStats            = clone $emptyStat;
                $playerStats->player_id = $player->id;
                $playerStats->player    = $player;
                $playerStats->games     = 0;
            }

            // And push to main collection
            $allStats->push($playerStats);
        }

        return self::optimizePlayerDataForLeaderboards($allStats, 'all');
    }

    public static function playersEventStats($playerId = null, $limit = 20, ?int $eventId = null): array
    {
        $stats = [
            'score'        => self::playerEventStatsSingle('score', 'score', 'desc', $limit, $eventId),
            'three_points' => self::playerEventStatsSingle('three_points', 'three_points_made', 'desc', $limit, $eventId),
            'field_goals'  => self::playerEventStatsSingle('field_goals', 'field_goals_percent', 'desc', $limit, $eventId), // self::playerEventFieldGoals($limit),
            'free_throws'  => self::playerEventStatsSingle('free_throws', 'free_throws_percent', 'desc', $limit, $eventId),
            'assists'      => self::playerEventStatsSingle('assists', 'assists', 'desc', $limit, $eventId), // self::playerEventAssists($limit),
            'rebounds'     => self::playerEventStatsSingle('rebounds', 'rebounds', 'desc', $limit, $eventId), // self::playerEventRebounds($limit),
            'blocks'       => self::playerEventStatsSingle('blocks', 'blocks', 'desc', $limit, $eventId),
            'steals'       => self::playerEventStatsSingle('steals', 'steals', 'desc', $limit, $eventId),
            'fouls'        => self::playerEventStatsSingle('fouls', 'fouls', 'desc', $limit, $eventId),
            'turnovers'    => self::playerEventStatsSingle('turnovers', 'turnovers', 'desc', $limit, $eventId),
            'efficiency'   => self::playerEventStatsSingle('efficiency', 'efficiency', 'desc', $limit, $eventId),
        ];

        return $stats;
    }

    public static function playerEventStatsSingle($type, $column, $order = 'desc', $limit = 20, ?int $eventId = null)
    {
        // When no eventId, use 'total' stats; otherwise use 'event' stats for specific event
        $statsType = $eventId ? 'event' : 'total';

        if ($type === 'free_throws') {
            $query = Stat::with(['player', 'player.media'])
                ->where('for', 'player')
                ->where('type', $statsType)
                ->orderByRaw("CASE WHEN {$type}_made >= 5 THEN 0 ELSE 1 END")
                ->orderByRaw("{$type}_percent DESC")
                ->orderByRaw("{$type}_made DESC")
                ->take($limit);

            if ($eventId) {
                $query->where('event_id', $eventId);
            }

            $stats = $query->get();
        } else {
            $query = Stat::with(['player', 'player.media'])
                ->where('for', 'player')
                ->where('type', $statsType)
                ->take($limit)
                ->orderBy($column, $order);

            if ($eventId) {
                $query->where('event_id', $eventId);
            }

            $stats = $query->get();
        }

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
        $optimizedItem = $item ? $item->toArray() : [];

        if ($item) {
            // Add stuff
            $optimizedItem['team_title'] = $item->team->title;
            $optimizedItem['team_logo']  = $item->team->logo();
            $optimizedItem['team_slug']  = $item->team->slug;

            // Remove stuff
            unset($optimizedItem['team']);
        }

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
                'games',
            ]);
        } else {
            $optimizedItem = $optimizedItem;
        }

        return $optimizedItem;
    }
}
