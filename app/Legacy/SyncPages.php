<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class SyncPages
{
    public
    static function run()
    {
        // Get legacy pages
        DB::connection('mysql_legacy')->table('wp_posts')
            ->where('post_type', 'page')
            ->get()
            ->each(function ($page) {
                // Create new page
                $newPage               = new \App\Models\Page();
                $newPage->external_id  = $page->ID;
                $newPage->title        = $page->post_title;
                $newPage->slug         = $page->post_name;
                $newPage->body         = $page->post_content;
                $newPage->created_at   = $page->post_date;
                $newPage->published_at = $page->post_modified;
                $newPage->updated_at   = $page->post_modified;
                $newPage->save();
            });
    }
}
