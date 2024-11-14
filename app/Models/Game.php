<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $casts = [
        'id'           => 'string',
        'external_id'  => 'integer',
        'event_id'     => 'integer',
        'round_id'     => 'integer',
        'home_team_id' => 'integer',
        'away_team_id' => 'integer',
        'data'         => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function referees(): HasMany
    {
        return $this->hasMany(Referee::class);
    }
}
