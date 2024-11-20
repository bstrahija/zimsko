<?php

namespace App\Leaderboards;

use Illuminate\Support\Collection;

class Leaderboard extends Collection
{
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
