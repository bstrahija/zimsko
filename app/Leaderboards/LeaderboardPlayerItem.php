<?php

namespace App\Leaderboards;

use App\Models\Player;
use App\Models\Team;
use App\Services\Stats;

class LeaderboardPlayerItem
{
    readonly public string $id;

    readonly public string $title;

    protected array $data;

    /**
     * @var Player
     */
    readonly public Player $player;

    /**
     * @var Team
     */
    readonly public Team $team;

    /**
     * New standing
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->id            = isset($data['id'])     ? $data['id']     : '';
        $this->title         = isset($data['title'])  ? $data['title']  : '';
        $this->player        = isset($data['player']) ? $data['player'] : null;
        $this->team          = isset($data['team'])   ? $data['team']   : null;
        $this->data['games'] = isset($data['games'])  ? $data['games']   : 0;

        foreach (config('stats.columns') as $column) {
            $this->data[$column['id']] = isset($data[$column['id']]) ? $data[$column['id']] : 0;
        }

        foreach (config('stats.calculated_columns') as $column) {
            $this->data[$column['id']] = isset($data[$column['id']]) ? $data[$column['id']] : 0;
        }
    }

    public function addStats($data)
    {
        foreach (config('stats.columns') as $column) {
            if (isset($data[$column['id']])) {
                $this->data[$column['id']] += $data[$column['id']];
            }
        }
    }

    public function calculate()
    {
        // Here we calculations for all the calculated columns
        foreach (config('stats.calculated_columns') as $column) {
            if ($column['method'] === 'avg') {
                $this->data[$column['id']] = $this->data['games'] ? round($this->data[str_replace('_avg', '', $column['id'])] / $this->data['games'], 2) : 0;
            } elseif ($column['method'] === 'percent') {
                $attemptColumn = str_replace('_percent', '', $column['id']);
                $madeColumn    = $attemptColumn . '_made';
                $attempted     = $this->data[$attemptColumn];
                $made          = $this->data[$madeColumn];
                $this->data[$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
            } elseif ($column['method'] === 'efficiency') {
                $this->data[$column['id']] = Stats::calculateEfficiency($this->data);
            }
        }
    }

    public function addGames($games = 1)
    {
        $this->data['games'] += $games;
    }

    public function addScore($score = 1)
    {
        $this->data['score'] += $score;
    }

    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->key;
        }

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'data' => $this->data,
        ];
    }
}
