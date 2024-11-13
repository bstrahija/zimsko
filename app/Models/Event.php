<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'id' => 'integer',
        'external_id' => 'integer',
        'data' => 'array',
        'scheduled_at' => 'timestamp',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
