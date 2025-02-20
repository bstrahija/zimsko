<?php

namespace App\LiveScore\Traits;

use App\Models\GameLog;
use App\Models\Player;
use Illuminate\Support\Collection;

trait LogData
{
    protected ?Collection $log;

    public function addLog($data): GameLog
    {
        // Find the player
        $player  = isset($data['player_id'])   ? $this->findPlayer($data['player_id']) : null;
        $player2 = isset($data['player_2_id']) ? $this->findPlayer($data['player_2_id']) : null;

        // And the team
        if (isset($data['team_id'])) {
            $isInHomeTeam = $data['team_id'] === $this->homeTeam->id;
            $team         = $isInHomeTeam ? $this->homeTeam : $this->awayTeam;
        } elseif (isset($player)) {
            $isInHomeTeam = $this->homePlayers->contains('id', $player->id);
            $team         = $isInHomeTeam ? $this->homeTeam : $this->awayTeam;
        }

        // Also get the scores from the last log entry and update them if needed
        $lastLog   = $this->log->sortByDesc('id')->first();
        $homeScore = $lastLog->home_score;
        $awayScore = $lastLog->away_score;

        // Now update the scores
        if ($data['type'] === 'player_score' || $data['type'] === 'player_score_with_assist') {
            $homeScore += $isInHomeTeam  ? $data['amount'] : 0;
            $awayScore += !$isInHomeTeam ? $data['amount'] : 0;
        }

        // Create log entry
        $item                = new GameLog();
        $item->game_id       = $this->game->id;
        $item->type          = $data['type'];
        $item->subtype       = $data['subtype'] ?? null;
        $item->player_id     = $data['player_id'] ?? null;
        $item->player_name   = $player ? $player->name : null;
        $item->player_2_name = $player2 ? $player2->name : null;
        $item->player_2_id   = $data['player_2_id'] ?? null;
        $item->team_id       = isset($team) && $team ? $team->id : null;
        $item->team_name     = isset($team) && $team ? $team->title : null;
        $item->team_side     = isset($isInHomeTeam) ? ($isInHomeTeam ? 'home' : 'away') : null;
        $item->amount        = $data['amount'] ?? null;
        $item->period        = $data['period'] ?? $this->currentPeriod();
        $item->occurred_at   = $data['occurred_at'] ?? '00:00:00';
        $item->home_score    = $homeScore ?? 0;
        $item->away_score    = $awayScore ?? 0;
        $item->save();

        return $item;
    }

    public function log(): Collection
    {
        return $this->log;
    }

    /**
     * A simplified log stream
     *
     * @return array
     */
    public function logStream(): array
    {
        $stream = [];

        foreach ($this->log as $log) {
            if (!in_array($log->type, ['player_assist'])) {
                $item = [
                    'id'            => $log->id,
                    'type'          => $log->type,
                    'subtype'       => $log->subtype,
                    'period'        => $log->period,
                    'occurred_at'   => $log->occurred_at,
                    'occurred_at_p' => $log->occurred_at_p,
                    'amount'        => $log->amount,
                    'home_score'    => $log->home_score,
                    'away_score'    => $log->away_score,
                    'team_id'       => $log->team_id,
                    'team_name'     => $log->team_name,
                    'team_side'     => $log->team_side,
                    'player_id'     => $log->player_id,
                    'player_name'   => $log->player_name,
                    'created_at'    => $log->created_at->format('Y-m-d H:i:s'),
                ];

                // Let's build up a message
                $message = '';
                if ($log->type === 'game_initialized')              $message = $this->logMessageForGameInitialized($log);
                else if ($log->type === 'game_starting_players')    $message = $this->logMessageForStartingPlayers($log);
                else if ($log->type === 'game_started')             $message = 'Utakmica je započela: ' . $log->created_at->format('d.m. h:i:s');
                else if ($log->type === 'period_started')           $message = $this->logMessageForPeriod($log, 'start');
                else if ($log->type === 'period_ended')             $message = $this->logMessageForPeriod($log, 'end');
                else if ($log->type === 'game_ended')               $message = 'Utakmica je završena: ' . $log->created_at->format('d.m. h:i:s');
                else if ($log->type === 'player_score')             $message = $this->logMessageForPlayerScore($log);
                else if ($log->type === 'player_miss')              $message = $this->logMessageForPlayerMiss($log);
                else if ($log->type === 'player_score_with_assist') $message = $this->logMessageForPlayerScore($log);
                else if ($log->type === 'player_assist')            $message = $this->logMessageForPlayerAssist($log);
                else if ($log->type === 'player_foul')              $message = $this->logMessageForPlayerFoul($log);
                else if ($log->type === 'player_block')             $message = $this->logMessageForPlayerBlock($log);
                else if ($log->type === 'player_rebound')           $message = $this->logMessageForPlayerRebound($log);
                else if ($log->type === 'player_steal')             $message = $this->logMessageForPlayerSteal($log);
                else if ($log->type === 'player_turnover')          $message = $this->logMessageForPlayerTurnover($log);
                else if ($log->type === 'team_technical_foul')      $message = $this->logMessageForTeamTechnical($log);
                else if ($log->type === 'substitution')             $message = $this->logMessageForPlayerSubstitution($log);
                else if ($log->type === 'timeout')                  $message = 'Pozvan timeout: ' . $log->team_name;
                else                                                $message = $log->type;

                // Add message to log
                $item['message'] = $message;

                // Add to stream
                $stream[] = $item;
            }
        }

        return $stream;
    }

    public function logMessageForPeriod(GameLog $log, $type = 'start'): string
    {
        if ($log->period <= 4) {
            $message = ($type === 'start' ? 'Počela je ' : 'Završila je') . ' ' . $log->period;
            $message .= '. četvrtina: ' . $log->created_at->format('d.m. h:i:s');
        } else {
            $message = ($type === 'start' ? 'Počeo je ' : 'Završio je') . ' ' . ($log->period - 4);
            $message .= '. produžetak: ' . $log->created_at->format('d.m. h:i:s');
        }

        return $message;
    }

    public function logMessageForGameInitialized(GameLog $log): string
    {
        $message  = 'Utakmica je spremna: ' . $log->created_at->format('d.m. h:i:s');
        // $message .= 'Domaća ekipa: ' . $this->homeTeam->title . ' (' . $this->homePlayers->pluck('name')->implode(', ') . ')<br>';
        // $message .= 'Gostujuća ekipa: ' . $this->awayTeam->title . ' (' . $this->awayPlayers->pluck('name')->implode(', ') . ')<br>';

        return $message;
    }

    public function logMessageForStartingPlayers(GameLog $log): string
    {
        // $homePlayers = $this->gameLive->home_starting_players ? Player::whereIn('id', $this->gameLive->home_starting_players)->get() : null;
        // $awayPlayers = $this->gameLive->away_starting_players ? Player::whereIn('id', $this->gameLive->away_starting_players)->get() : null;

        $message = 'Odabrane petorke';
        // $message .= $this->homeTeam->title . ': ' . $homePlayers->pluck('name')->implode(', ');
        // $message .= '<br>' . $this->awayTeam->title . ': ' . $awayPlayers->pluck('name')->implode(', ');

        return $message;
    }

    public function logMessageForPlayerScore(GameLog $log): string
    {
        if ($log->amount === 1) {
            $message = $log->player_name . ' pogađa slobodno bacanje';
        } elseif ($log->amount === 3) {
            $message = $log->player_name . ' pogađa tricu';
        } else {
            $message = $log->player_name . ' pogađa za ' . $log->amount . ' poena';
        }

        if ($log->player_2_id) {
            $message .= ' (asistencija: ' . $log->player_2_name . ')';
        }

        return $message;
    }

    public function logMessageForPlayerMiss(GameLog $log): string
    {
        if ($log->amount === 1) {
            $message = $log->player_name . ' promašuje slobodno bacanje';
        } elseif ($log->amount === 3) {
            $message = $log->player_name . ' promašuje tricu';
        } else {
            $message = $log->player_name . ' promašuje za ' . $log->amount . ' poena';
        }

        return $message;
    }

    public function logMessageForPlayerAssist(GameLog $log): string
    {
        $message = $log->player_name . ' asistira ';

        if ($log->player_2_id) {
            $message .= ' ' . $log->player_2_name . ' za ' . $log->amount . ' poena';
        }

        return $message;
    }

    public function logMessageForPlayerFoul(GameLog $log): string
    {
        if ($log->subtype === 'tf') {
            $message = 'Tehnička dosuđena: ' . $log->player_name;
        } elseif ($log->subtype === 'ff') {
            $message = 'Nesportska dosuđena: ' . $log->player_name . ($log->player_2_id ? ' na ' . $log->player_2_name : '');
        } else {
            $message = 'Dosuđen prekršaj: ' . $log->player_name . ($log->player_2_id ? ' na ' . $log->player_2_name : '');
        }

        return $message;
    }

    public function logMessageForTeamTechnical(GameLog $log): string
    {
        return $message = 'Tehnička dosuđena: ' . $log->team_name;
    }

    public function logMessageForPlayerBlock(GameLog $log): string
    {
        $message  = $log->player_name . ' blokira šut ';

        if ($log->player_2_id) {
            $message .= ' od ' . $log->player_2_name;
        }

        return $message;
    }

    public function logMessageForPlayerSteal(GameLog $log): string
    {
        $message  = $log->player_name . ' krade loptu ';

        if ($log->player_2_id) {
            $message .= ' od ' . $log->player_2_name;
        }

        return $message;
    }

    public function logMessageForPlayerRebound(GameLog $log): string
    {
        if ($log->subtype === 'oreb') {
            $message = 'Skok u napadu: ' . $log->player_name;
        } elseif ($log->subtype === 'dreb') {
            $message = 'Skok u obrani: ' . $log->player_name;
        } else {
            $message = 'Skok: ' . $log->player_name;
        }

        return $message;
    }

    public function logMessageForPlayerTurnover(GameLog $log): string
    {
        $message  = $log->player_name . ' izgubio loptu';

        if ($log->player_2_id) {
            $message .= ' od ' . $log->player_2_name;
        }

        return $message;
    }

    public function logMessageForPlayerSubstitution(GameLog $log): string
    {
        $message  = 'Izmjena, ulazi ' . $log->player_name . ' umjesto ' . $log->player_2_name;

        return $message;
    }

    public function refreshLog()
    {
        $this->log = GameLog::where('game_id', $this->game->id)
            ->orderBy('period', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('occurred_at', 'desc')
            ->get();
    }

    public function clearLog()
    {
        GameLog::where('game_id', $this->game->id)
            ->whereNotIn('type', ['game_initialized', 'game_started'])
            ->delete();
    }
}
