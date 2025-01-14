<?php

namespace App\Legacy;

use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use App\Models\Round;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SyncRounds
{
    public static function run()
    {
        // Create rounds for each event
        $events = Event::all();

        foreach ($events as $event) {
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-1-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '1. kolo',   'slug' => $event->slug . '-1-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-2-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '2. kolo',   'slug' => $event->slug . '-2-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-3-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '3. kolo',   'slug' => $event->slug . '-3-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-4-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '4. kolo',   'slug' => $event->slug . '-4-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-5-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '5. kolo',   'slug' => $event->slug . '-5-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-6-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '6. kolo',   'slug' => $event->slug . '-6-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-7-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '7. kolo',   'slug' => $event->slug . '-7-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-8-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '8. kolo',   'slug' => $event->slug . '-8-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-9-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '9. kolo',   'slug' => $event->slug . '-9-kolo', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-10-kolo')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => '10. kolo', 'slug' => $event->slug . '-10-kolo', 'status' => 'completed']);

            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-razigravanje')->exists()) Round::query()->create(['event_id' => $event->id, 'title' => 'Razigravanje', 'slug' => $event->slug . '-razigravanje', 'type' => 'round-robin', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-za-9-mjesto')->exists())  Round::query()->create(['event_id' => $event->id, 'title' => 'Za 9. mjesto', 'slug' => $event->slug . '-za-9-mjesto',  'type' => 'placing',     'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-za-7-mjesto')->exists())  Round::query()->create(['event_id' => $event->id, 'title' => 'Za 7. mjesto', 'slug' => $event->slug . '-za-7-mjesto',  'type' => 'placing',     'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-za-5-mjesto')->exists())  Round::query()->create(['event_id' => $event->id, 'title' => 'Za 5. mjesto', 'slug' => $event->slug . '-za-5-mjesto',  'type' => 'placing',     'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-za-3-mjesto')->exists())  Round::query()->create(['event_id' => $event->id, 'title' => 'Za 3. mjesto', 'slug' => $event->slug . '-za-3-mjesto',  'type' => 'placing',     'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-polufinale')->exists())   Round::query()->create(['event_id' => $event->id, 'title' => 'Polufinale',   'slug' => $event->slug . '-polufinale',   'type' => 'semi-finals', 'status' => 'completed']);
            if (! Round::where('event_id', $event->id)->where('slug', $event->slug . '-finale')->exists())       Round::query()->create(['event_id' => $event->id, 'title' => 'Finale',       'slug' => $event->slug . '-finale',       'type' => 'finals',      'status' => 'completed']);
        }

        // Once we have all rounds we need to assign games to them based on the game title
        $games = Game::all();

        foreach ($games as $game) {
            $round = null;
            if (Str::contains($game->title, '1. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-1-kolo')->first();
            if (Str::contains($game->title, '2. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-2-kolo')->first();
            if (Str::contains($game->title, '3. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-3-kolo')->first();
            if (Str::contains($game->title, '4. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-4-kolo')->first();
            if (Str::contains($game->title, '5. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-5-kolo')->first();
            if (Str::contains($game->title, '6. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-6-kolo')->first();
            if (Str::contains($game->title, '7. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-7-kolo')->first();
            if (Str::contains($game->title, '8. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-8-kolo')->first();
            if (Str::contains($game->title, '9. kolo',  true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-9-kolo')->first();
            if (Str::contains($game->title, '10. kolo', true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-10-kolo')->first();

            if (Str::contains($game->title, 'Razigravanje', true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-razigravanje')->first();
            if (Str::contains($game->title, '9. mjesto', true))    $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-za-9-mjesto')->first();
            if (Str::contains($game->title, '7. mjesto', true))    $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-za-7-mjesto')->first();
            if (Str::contains($game->title, '5. mjesto', true))    $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-za-5-mjesto')->first();
            if (Str::contains($game->title, '3. mjesto', true))    $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-za-3-mjesto')->first();

            if (Str::contains($game->title, 'finale ', true) || Str::contains($game->title, 'finalno', true)) $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-finale')->first();
            if (Str::contains($game->title, 'polufinale ', true))    $round = Round::where('event_id', $game->event_id)->where('slug', $game->event->slug . '-polufinale')->first();

            if ($round) {
                $game->round_id = $round->id;
                $game->save();

                // We also update the round schedule
                $round->update(['scheduled_at' => $game->scheduled_at->format('Y-m-d') . ' 08:00:00']);
            }
        }
    }
}
