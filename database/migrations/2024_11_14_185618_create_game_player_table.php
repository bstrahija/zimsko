<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_player', function (Blueprint $table) {
            $table->id();
            $table->string('game_id')->constrained('games')->cascadeOnDelete()->index();
            $table->string('player_id')->constrained('players')->cascadeOnDelete()->index();
            $table->string('team_id')->nullable()->constrained('teams')->cascadeOnDelete()->index();
            $table->integer('score')->default(0);
            $table->integer('three_points')->default(0);
            $table->integer('three_points_made')->default(0);
            $table->float('three_points_percent')->default(0);
            $table->integer('two_points')->default(0);
            $table->integer('two_points_made')->default(0);
            $table->float('two_points_percent')->default(0);
            $table->integer('field_goals')->default(0);
            $table->integer('field_goals_made')->default(0);
            $table->float('field_goals_percent')->default(0);
            $table->integer('free_throws')->default(0);
            $table->integer('free_throws_made')->default(0);
            $table->float('free_throws_percent')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('blocks')->default(0);
            $table->integer('steals')->default(0);
            $table->integer('turnovers')->default(0);
            $table->integer('rebounds')->default(0);
            $table->integer('offensive_rebounds')->default(0);
            $table->integer('defensive_rebounds')->default(0);
            $table->integer('fouls')->default(0);
            $table->integer('personal_fouls')->default(0);
            $table->integer('technical_fouls')->default(0);
            $table->integer('flagrant_fouls')->default(0);
            $table->float('efficiency')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_player');
    }
};
