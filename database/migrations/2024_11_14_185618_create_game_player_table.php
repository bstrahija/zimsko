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
            $table->integer('points')->default(0);
            $table->integer('three_points')->default(0);
            $table->integer('two_points')->default(0);
            $table->integer('free_throws')->default(0);
            $table->integer('free_throws_attempted')->default(0);
            $table->integer('two_points_attempted')->default(0);
            $table->integer('three_points_attempted')->default(0);
            $table->integer('personal_fouls')->default(0);
            $table->integer('technical_fouls')->default(0);
            $table->integer('rebounds')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('blocks')->default(0);
            $table->integer('steals')->default(0);
            $table->integer('turnovers')->default(0);
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
