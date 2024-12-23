<?php

namespace App\Legacy;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class Sync3pts
{
    public static function run()
    {
        $players = [
            'stjepan-kranjcec' => ['games' => [
                '3-mjesto-pozoji-agrow-basket'          => 4,
                '8-kolo-agrow-basket-parks'             => 5,
                '7-kolo-kk-rudar-veterani-agrow-basket' => 6,
                '5-kolo-agrow-basket-stoperi-fiskal'    => 5,
                '4-kolo-pilipinas-agrow-basket'         => 9,
                '3-kolo-ppc-agrow-basket'               => 8,
                '2-kolo-bc-nording-agrow-basket'        => 6,
                '1-kolo-agm-basket-agrow-basket'        => 5,
            ], 'made' => 48],
            'ivan-segovic' => ['games' => [
                '3-mjesto-pozoji-agrow-basket'           => 3,
                '9-kolo-agrow-basket-pozoji-krit-centar' => 4,
                '6-kolo-agrow-basket-euro-opus'          => 10,
                '5-kolo-agrow-basket-stoperi-fiskal'     => 5,
                '4-kolo-pilipinas-agrow-basket'          => 8,
            ], 'made' => 30],
            'matija-megla' => ['games' => [
                'finale-basket-case-parks' => 2,
                '9-kolo-stoperi-fiskal-bc-nording' => 4,
                '8-kolo-bc-nording-pilipinas' => 3,
                '7-kolo-ppc-bc-nording' => 4,
                '6-kolo-bc-nording-kk-rudar-veterani' => 2,
                '5-kolo-bc-nording-euro-opus' => 1,
                '4-kolo-parks-bc-nording' => 3,
                '2-kolo-bc-nording-agrow-basket' => 1,
                '1-kolo-pozoji-krit-centar-bc-nording' => 2,
            ], 'made' => 22],
            'jepoy-palma' => ['games' => [
                '9-kolo-euro-opus-parks' => 2,
                '8-kolo-euro-opus-stoperi-fiskal' => 2,
                '7-kolo-euro-opus-pozoji-krit-centar' => 2,
                '6-kolo-agrow-basket-euro-opus' => 3,
                '5-kolo-bc-nording-euro-opus' => 2,
                '4-kolo-euro-opus-kk-rudar-veterani' => 2,
                '3-kolo-pilipinas-euro-opus' => 2,
                '2-kolo-agm-basket-euro-opus' => 2,
                '1-kolo-ppc-euro-opus' => 2,
            ], 'made' => 19],
            'matija-terek' => ['games' => [
                '9-kolo-kk-rudar-veterani-agm-basket' => 3,
                '8-kolo-pozoji-krit-centar-agm-basket' => 3,
                '7-kolo-pilipinas-agm-basket' => 3,
                '6-kolo-agm-basket-stoperi-fiskal' => 3,
                '5-kolo-agm-basket-parks' => 2,
                '2-kolo-agm-basket-euro-opus' => 2,
                '1-kolo-agm-basket-agrow-basket' => 2,
            ], 'made' => 18],
            'mladen-tkalec' => ['games' => [
                '5-mjesto-ppc-rudar' => 3,
                '9-kolo-kk-rudar-veterani-agm-basket' => 2,
                '7-kolo-kk-rudar-veterani-agrow-basket' => 3,
                '8-kolo-kk-rudar-veterani-ppc' => 3,
                '5-kolo-kk-rudar-veterani-pilipinas' => 2,
                '2-kolo-pozoji-krit-centar-kk-rudar-veterani' => 3,
            ], 'made' => 16],
            'edie-boy-coloma' => ['games' => [
                '9-kolo-pilipinas-ppc' => 3,
                '8-kolo-bc-nording-pilipinas' => 2,
                '7-kolo-pilipinas-agm-basket' => 3,
                '6-kolo-pozoji-krit-centar-pilipinas' => 2,
                '4-kolo-pilipinas-agrow-basket' => 3,
                '3-kolo-pilipinas-euro-opus' => 2,
                '2-kolo-parks-pilipinas' => 1,
            ], 'made' => 16],
            'petar-glumac' => ['games' => [
                '3-mjesto-pozoji-agrow-basket' => 2,
                '9-kolo-agrow-basket-pozoji-krit-centar' => 1,
                '8-kolo-pozoji-krit-centar-agm-basket' => 3,
                '7-kolo-euro-opus-pozoji-krit-centar' => 1,
                '5-kolo-pozoji-krit-centar-ppc' => 2,
                '4-kolo-stoperi-fiskal-pozoji-krit-centar' => 3,
                '2-kolo-pozoji-krit-centar-kk-rudar-veterani' => 1,
                '4-kolo-agm-basket-vs-pozoji' => 2,
            ], 'made' => 15],
            'ivica-kasapovic' => ['games' => [
                '9-kolo-stoperi-fiskal-bc-nording' => 2,
                '8-kolo-euro-opus-stoperi-fiskal' => 1,
                '7-kolo-stoperi-fiskal-parks' => 2,
                '6-kolo-agm-basket-stoperi-fiskal' => 3,
                '5-kolo-agrow-basket-stoperi-fiskal' => 2,
                '4-kolo-stoperi-fiskal-pozoji-krit-centar' => 2,
                '3-kolo-stoperi-fiskal-kk-rudar-veterani' => 1,
                '1-kolo-stoperi-fiskal-pilipinas' => 1,
            ], 'made' => 14],
            'davor-baksa' => ['games' => [
                '9-kolo-kk-rudar-veterani-agm-basket' => 2,
                '8-kolo-pozoji-krit-centar-agm-basket' => 2,
                '7-kolo-pilipinas-agm-basket' => 1,
                '6-kolo-agm-basket-stoperi-fiskal' => 2,
                '5-kolo-agm-basket-parks' => 2,
                '4-kolo-ppc-agm-basket' => 1,
                '3-kolo-agm-basket-bc-nording' => 1,
                '2-kolo-agm-basket-euro-opus' => 1,
                '1-kolo-agm-basket-agrow-basket' => 1,
            ], 'made' => 13],
        ];

        foreach ($players as $playerSlug => $data) {
            $player = Player::where('slug', $playerSlug)->first();

            if ($player) {
                $threePointsAdded = 0;

                foreach ($data['games'] as $gameSlug => $threePointsMade) {
                    $game = Game::where('slug', $gameSlug)->first();

                    if ($game) {
                        $gamePlayer = GamePlayer::where(['player_id' => $player->id, 'game_id' => $game->id])->first();
                        $threePointsAttempted = round(($threePointsMade * 2.1) - 1, 0);

                        if ($gamePlayer) {
                            $gamePlayer->update([
                                'three_points_made' => $threePointsMade,
                                'three_points'      => $threePointsAttempted,
                            ]);
                            $threePointsAdded += $threePointsMade;
                        }
                    }
                }
            }
        }
    }
}
