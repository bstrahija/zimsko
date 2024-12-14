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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('game')->nullable();
            $table->string('for')->default('team')->nullable();
            $table->foreignUlid('event_id')->nullable()->constrained('events')->onDelete('cascade');
            $table->foreignUlid('game_id')->nullable()->constrained('games')->onDelete('cascade');
            $table->foreignUlid('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignUlid('player_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->integer('games')->default(1);
            $table->integer('score')->nullable();
            $table->integer('field_goals')->nullable();
            $table->integer('field_goals_made')->nullable();
            $table->float('field_goals_percent')->nullable();
            $table->integer('two_points')->nullable();
            $table->integer('two_points_made')->nullable();
            $table->float('two_points_percent')->nullable();
            $table->integer('three_points')->nullable();
            $table->integer('three_points_made')->nullable();
            $table->float('three_points_percent')->nullable();
            $table->integer('free_throws')->nullable();
            $table->integer('free_throws_made')->nullable();
            $table->float('free_throws_percent')->nullable();
            $table->integer('rebounds')->nullable();
            $table->integer('offensive_rebounds')->nullable();
            $table->integer('defensive_rebounds')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('steals')->nullable();
            $table->integer('blocks')->nullable();
            $table->integer('turnovers')->nullable();
            $table->integer('fouls')->nullable();
            $table->integer('timeouts')->nullable();
            $table->float('efficiency')->nullable();
            $table->integer('technical_fouls')->nullable();
            $table->integer('personal_fouls')->nullable();
            $table->integer('flagrant_fouls')->nullable();
            $table->integer('score_p1')->nullable();
            $table->integer('score_p2')->nullable();
            $table->integer('score_p3')->nullable();
            $table->integer('score_p4')->nullable();
            $table->integer('score_p5')->nullable();
            $table->integer('score_p6')->nullable();
            $table->integer('score_p7')->nullable();
            $table->integer('score_p8')->nullable();
            $table->integer('score_p9')->nullable();
            $table->integer('score_p10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
