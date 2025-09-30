<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = [
        'event_id',
        'game_id',
        'team_id',
        'player_id',
        'type',
        'title',
        'description',
        'is_active',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function getTypeConfigAttribute()
    {
        return config('achievements.' . $this->type);
    }

    public function getTitleAttribute()
    {
        $config = config('achievements.' . $this->type);
        $title  = $config ? $config['title'] : $this->type;

        return $title;
    }
}
