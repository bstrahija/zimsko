<?php

namespace App\Leaderboards;

use App\Models\Player;
use App\Models\Team;
use App\Stats\Stats;

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
