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
    public static function teamEventStats($limit = 20): array
    {
        $stats = Stat::with(['team', 'team.media'])->where('for', 'team')->where('type', 'event')->where('event_id', Event::current()->id)->get();

        return self::optimizeTeamDataForLeaderboards($stats);
    }

    public static function playerEventStats($limit = 20): array
    {
        $stats = [
            'score'        => self::playerEventScores($limit),
            'three_points' => self::playerEventThreePoints($limit),
            'field_goals'  => self::playerEventFieldGoals($limit),
            'free_throws'  => self::playerEventFreeThrows($limit),
            'assists'      => self::playerEventAssists($limit),
            'rebounds'     => self::playerEventRebounds($limit),
            'blocks'       => self::playerEventBlocks($limit),
            'steals'       => self::playerEventSteals($limit),
            'fouls'        => self::playerEventFouls($limit),
            'turnovers'    => self::playerEventTurnovers($limit),
            'efficiency'   => self::playerEventEfficiency($limit),
        ];

        return $stats;
    }

    public static function playerEventScores($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('score', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats);
    }

    public static function playerEventThreePoints($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('three_points_made', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'three_points');
    }

    public static function playerEventFieldGoals($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('field_goals_percent', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'field_goals');
    }

    public static function playerEventFreeThrows($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('free_throws_percent', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'free_throws');
    }

    public static function playerEventAssists($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('assists', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'assists');
    }

    public static function playerEventRebounds($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('rebounds', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'rebounds');
    }

    public static function playerEventBlocks($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('blocks', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'blocks');
    }

    public static function playerEventSteals($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('steals', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'steals');
    }

    public static function playerEventTurnovers($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('turnovers', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'turnovers');
    }

    public static function playerEventFouls($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('fouls', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'fouls');
    }

    public static function playerEventEfficiency($limit = 20): array
    {
        $stats = Stat::with(['player', 'player.media'])->where('for', 'player')->where('type', 'event')->where('event_id', Event::current()->id)->orderBy('efficiency', 'desc')->take($limit)->get();

        return self::optimizePlayerDataForLeaderboards($stats, 'efficiency');
    }

    protected static function optimizeTeamDataForLeaderboards(Collection $data): array
    {
        $optimizedData = [];

        foreach ($data as $item) {
            $optimizedItem = $item->toArray();

            // Add stuff
            $optimizedItem['team_title'] = $item->team->title;
            // $optimizedItem['team_logo']  = $optimizedItem['team']['media'][1]['original_url'];

            // Remove stuff
            unset($optimizedItem['team']);

            // Push it
            $optimizedData[] = $optimizedItem;
        }

        return $optimizedData;
    }

    protected static function optimizePlayerDataForLeaderboards(Collection $data, $type = 'score'): array
    {
        $optimizedData = [];

        foreach ($data as $item) {
            $optimizedItem = $item->toArray();

            // Add stuff
            $optimizedItem['player_name']  = $item->player->name;
            // $optimizedItem['player_photo'] = $optimizedItem['player']['photo'];

            // Remove stuff
            unset($optimizedItem['player']);
            $optimizedItem = Arr::only($optimizedItem, [
                'id',
                'player_photo',
                'player_name',
                $type,
                $type . '_made',
                $type . '_percent',
                'field_goals_percent',
                'offensive_rebounds',
                'defensive_rebounds',
            ]);

            // Push it
            $optimizedData[] = $optimizedItem;
        }

        return $optimizedData;
    }
}
