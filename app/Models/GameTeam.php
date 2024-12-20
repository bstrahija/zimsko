<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTeam extends Model
{
    protected $table = 'game_team';

    protected $guarded = [];
}
