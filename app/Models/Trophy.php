<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trophy extends Model
{
    use HasFactory;

    protected $casts = [
        'id'        => 'integer',
        'event_id'  => 'integer',
        'team_id'   => 'integer',
        'player_id' => 'integer',
    ];

    public function data(): ?array
    {
        return config('trophies.' . $this->trophy);
    }

    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }
}
