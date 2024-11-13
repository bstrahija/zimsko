<?php

namespace App\Legacy;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class Sync
{
    public function __construct()
    {
        //
    }

    public function run()
    {
        $this->syncEvents();
        $this->syncTeams();
        $this->syncPlayers();
        $this->syncGames();
        $this->syncCoaches();
        $this->syncReferees();
    }

    public function syncCategories() {}

    public function syncPosts()
    {
        // Get legacy posts
        DB::connection('mysql_legacy')->table('wp_posts')
            ->where('post_type', 'post')
            ->get()
            ->each(function ($post) {
                // Create new post
                $newPost = new \App\Models\Post();
                $newPost->external_id = $post->ID;
                $newPost->title = $post->post_title;
                $newPost->slug = $post->post_name;
                $newPost->body = $post->post_content;
                $newPost->created_at = $post->post_date;
                $newPost->published_at = $post->post_modified;
                $newPost->updated_at = $post->post_modified;
                $newPost->save();
            });
    }

    public function syncPages()
    {
        // Get legacy pages
        DB::connection('mysql_legacy')->table('wp_posts')
            ->where('post_type', 'page')
            ->get()
            ->each(function ($page) {
                // Create new page
                $newPage = new \App\Models\Page();
                $newPage->external_id = $page->ID;
                $newPage->title = $page->post_title;
                $newPage->slug = $page->post_name;
                $newPage->body = $page->post_content;
                $newPage->created_at = $page->post_date;
                $newPage->published_at = $page->post_modified;
                $newPage->updated_at = $page->post_modified;
                $newPage->save();
            });
    }

    public function syncEvents()
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_events')->get()
            ->each(function ($event) {
                $newEvent = new \App\Models\Event();
                $newEvent->external_id = $event->wp_id;
                $newEvent->slug = $event->slug;
                $newEvent->title = $event->title;
                $newEvent->status = $event->status;
                $newEvent->data = @json_decode($event->data);
                $newEvent->created_at = $event->created_at;
                $newEvent->updated_at = $event->updated_at;
                $newEvent->save();
            });
    }

    public function syncTeams($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_teams')->get()
            ->each(function ($team) use ($media) {
                $newTeam = new \App\Models\Team();
                $newTeam->external_id = $team->wp_id;
                $newTeam->title = $team->title;
                $newTeam->slug = $team->slug;
                $newTeam->body = $team->body;
                $newTeam->data = @json_decode($team->data);
                $newTeam->created_at = $team->created_at;
                $newTeam->updated_at = $team->updated_at;
                $newTeam->save();

                if ($media) {
                    // We also need to assign the media files
                    $data = @json_decode($team->data);

                    try {
                        if ($data && isset($data->photo) && $data->photo) $newTeam->addMediaFromUrl($data->photo)->toMediaCollection('photos');
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                    try {
                        if ($data && isset($data->logo) && $data->logo) $newTeam->addMediaFromUrl($data->logo)->toMediaCollection('logos');
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                    try {
                        if ($data && isset($data->background) && $data->background) $newTeam->addMediaFromUrl($data->background)->toMediaCollection('backgrounds');
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }
            });
    }

    public function syncPlayers($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_players')->get()
            ->each(function ($player) use ($media) {
                $newPlayer = new \App\Models\Player();
                $newPlayer->external_id = $player->wp_id;
                $newPlayer->name = $player->name;
                $newPlayer->slug = $player->slug;
                $newPlayer->body = $player->body;
                $newPlayer->position = $player->position;
                $newPlayer->number = $player->number;
                $newPlayer->birthday = $player->birthday;
                $newPlayer->status = $player->status;
                $newPlayer->data = @json_decode($player->data);
                $newPlayer->created_at = $player->created_at;
                $newPlayer->updated_at = $player->updated_at;
                $newPlayer->save();

                // We also need to assign the team
                $legacyTeams = DB::connection('mysql_legacy')->table('wp_zmsk_player_team')->where('player_id', $newPlayer->external_id)->get();

                $legacyTeams->each(function ($legacyTeam) use ($newPlayer) {
                    $team = \App\Models\Team::where('external_id', $legacyTeam->team_id)->first();
                    $newPlayer->teams()->attach($team);
                });


                // $team = \App\Models\Team::where('external_id', $player->team_id)->first();
                // $newPlayer->team_id = $team->id;
                // $newPlayer->save();

                if ($media) {
                    // We also need to assign the media files
                    $data = @json_decode($player->data);

                    try {
                        if ($data && isset($data->photo) && $data->photo) $newPlayer->addMediaFromUrl($data->photo)->toMediaCollection('photos');
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }
            });
    }

    public function syncGames() {}

    public function syncCoaches() {}

    public function syncReferees() {}

    public function syncPlayerStats() {}

    public function syncTeamStats() {}

    public function clear()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('media')->truncate();
        DB::table('posts')->truncate();
        DB::table('pages')->truncate();
        DB::table('events')->truncate();
        DB::table('teams')->truncate();
        DB::table('players')->truncate();
        DB::table('games')->truncate();
        DB::table('coaches')->truncate();
        DB::table('referees')->truncate();
        // DB::table('player_stats')->truncate();
        // DB::table('team_stats')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
