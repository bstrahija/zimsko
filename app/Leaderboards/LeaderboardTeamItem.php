<?php

namespace App\Leaderboards;

use App\Models\Team;

class LeaderboardTeamItem
{
    /**
     * Team title
     *
     * @var string
     */
    readonly public string $title;

    /**
     * Team ID
     *
     * @var string
     */
    readonly public string $id;

    /**
     * Total points in standing
     *
     * @var int
     */
    readonly public int $points;

    /**
     * Number of games played
     *
     * @var int
     */
    readonly public int $games;

    /**
     * Total wins in standings
     *
     * @var int
     */
    readonly public int $wins;

    /**
     * Total losses in standings
     *
     * @var int
     */
    readonly public int $losses;

    /**
     * Total draws in standings
     *
     * @var int
     */
    readonly public int $draws;

    /**
     * Total score in standings
     *
     * @var int
     */
    readonly public int $score;

    /**
     * Total opponent score in standings
     *
     * @var int
     */
    readonly public int $opponentScore;

    /**
     * Total score difference in standings
     *
     * @var int
     */
    readonly public int $scoreDifference;

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
        $this->id                = isset($data['id'])                    ? $data['id'] : '';
        $this->title             = isset($data['team']) && $data['team'] ? $data['team']->title : '';
        $this->games             = (int) isset($data['games'])           ? $data['games'] : 0;
        $this->points            = (int) isset($data['points'])          ? $data['points'] : 0;
        $this->wins              = (int) isset($data['wins'])            ? $data['wins'] : 0;
        $this->losses            = (int) isset($data['losses'])          ? $data['losses'] : 0;
        $this->draws             = (int) isset($data['draws'])           ? $data['draws'] : 0;
        $this->score             = (int) isset($data['score'])           ? $data['score'] : 0;
        $this->opponentScore     = (int) isset($data['opponentScore'])   ? $data['opponentScore'] : 0;
        $this->scoreDifference   = (int) isset($data['scoreDifference']) ? $data['scoreDifference'] : 0;
        $this->team              = isset($data['team'])                  ? $data['team'] : null;
    }

    public function team()
    {
        return $this->team;
    }

    public function points()
    {
        return $this->points;
    }

    public function games()
    {
        return $this->games;
    }

    public function wins()
    {
        return $this->wins;
    }

    public function losses()
    {
        return $this->losses;
    }

    public function draws()
    {
        return $this->draws;
    }

    public function addPoints($points = 1)
    {
        $this->points += $points;
    }

    public function score()
    {
        return $this->score;
    }

    public function opponentScore()
    {
        return $this->opponentScore;
    }

    public function scoreDifference()
    {
        return $this->score - $this->opponentScore;
    }

    public function addGames($games = 1)
    {
        $this->games += $games;
    }

    public function addWins($losses = 1)
    {
        $this->wins += $losses;
    }

    public function addLosses($losses = 1)
    {
        $this->losses += $losses;
    }

    public function addDraws($draws = 1)
    {
        $this->draws += $draws;
    }

    public function addScore($score = 1)
    {
        $this->score += $score;
    }

    public function addOpponentScore($score = 1)
    {
        $this->opponentScore += $score;
    }
}
