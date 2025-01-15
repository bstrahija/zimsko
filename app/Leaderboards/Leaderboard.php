<?php

namespace App\Leaderboards;

use App\Models\Event;
use Illuminate\Support\Collection;

class Leaderboard extends Collection
{
    public ?Event $event = null;

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function multiOrderBy($instructions)
    {
        return $this->sort(function ($a, $b) use ($instructions) {
            foreach ($instructions as $instruction) {
                if (empty($instruction['order']) or strtolower($instruction['order']) == 'asc') {
                    $x = ($a->{$instruction['column']} <=> $b->{$instruction['column']});
                } else {
                    $x = ($b->{$instruction['column']} <=> $a->{$instruction['column']});
                }

                if ($x != 0) {
                    return $x;
                }
            }

            return 0;
        });
    }
}
