<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class SyncPosts
{
    public
    static function run()
    {
        // Get legacy posts
        DB::connection('mysql_legacy')->table('wp_posts')
            ->where('post_type', 'post')
            ->get()
            ->each(function ($post) {
                // Create new post
                $newPost               = new \App\Models\Post();
                $newPost->external_id  = $post->ID;
                $newPost->title        = $post->post_title;
                $newPost->slug         = $post->post_name;
                $newPost->body         = $post->post_content;
                $newPost->created_at   = $post->post_date;
                $newPost->published_at = $post->post_modified;
                $newPost->updated_at   = $post->post_modified;
                $newPost->save();
            });
    }
}
