<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Player extends Model implements HasMedia
{
    use HasFactory, HasUlids, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'id'          => 'string',
        'external_id' => 'integer',
        'birthday'    => 'date',
        'data'        => 'array',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 600, 600)
            ->nonQueued();
    }
}
