<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leaderboard extends Model
{
    use HasFactory, HasTimestamps;

    protected $guarded = [];

    protected $casts = [
        'event_id' => 'integer',
        'data'     => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
