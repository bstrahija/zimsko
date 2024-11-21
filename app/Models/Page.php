<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasFactory, HasSlug, HasUlids, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'status',
        'published_at',
    ];

    protected $casts = [
        'id'           => 'string',
        'external_id'  => 'integer',
        'user_id'      => 'integer',
        'data'         => 'array',
        'published_at' => 'timestamp',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
