<?php

namespace App\Leaderboards;

use App\Models\Player;
use App\Models\Team;

class LeaderboardPlayerItem
{
    /**
     * Team title
     *
     * @var string
     */
    readonly public string $title;

    /**
     * Total points in standing
     *
     * @var int
     */
    readonly public int $points;

    /**
     * Total 3-pointers in standing
     *
     * @var int
     */
    readonly public int $threePointers;

    /**
     * Number of games played
     *
     * @var int
     */
    readonly public int $games;

    /**
     * Average points per game
     *
     * @var int
     */
    readonly public float $avg;

    /**
     * Average 3-pointers per game
     *
     * @var int
     */
    readonly public float $avgThreePointers;

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
        $this->title             = isset($data['title'])                  ? $data['title'] : '';
        $this->games             = (int) isset($data['games'])            ? $data['games'] : 0;
        $this->points            = (int) isset($data['points'])           ? $data['points'] : 0;
        $this->threePointers     = (int) isset($data['three_points'])     ? $data['three_points'] : 0;
        $this->avg               = (int) isset($data['avg'])              ? $data['avg'] : 0;
        $this->avgThreePointers  = (int) isset($data['avg_three_points']) ? $data['avg_three_points'] : 0;
        $this->player            = isset($data['player'])                 ? $data['player'] : null;
        $this->team              = isset($data['team'])                   ? $data['team'] : null;
    }

    public function player()
    {
        return $this->player;
    }

    public function points()
    {
        return $this->points;
    }

    public function games()
    {
        return $this->games;
    }

    public function avg()
    {
        return $this->avg;
    }

    public function addGames($games = 1)
    {
        $this->games += $games;
    }

    public function addPoints($points = 1)
    {
        $this->points += $points;
    }
}
