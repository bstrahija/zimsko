<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Round extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $casts = [
        'id'           => 'string',
        'external_id'  => 'integer',
        'event_id'     => 'string',
        'data'         => 'array',
        'scheduled_at' => 'timestamp',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
