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
        Schema::create('games_live', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('game_id')->constrained('games');
            $table->string('status')->default('pending');
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->integer('home_score_q1')->default(0);
            $table->integer('away_score_q1')->default(0);
            $table->integer('home_score_q2')->default(0);
            $table->integer('away_score_q2')->default(0);
            $table->integer('home_score_q3')->default(0);
            $table->integer('away_score_q3')->default(0);
            $table->integer('home_score_q4')->default(0);
            $table->integer('away_score_q4')->default(0);
            $table->integer('home_score_q5')->nullable();
            $table->integer('away_score_q5')->nullable();
            $table->integer('home_score_q6')->nullable();
            $table->integer('away_score_q6')->nullable();
            $table->integer('quarter')->default(1);
            $table->json('home_starting_players')->nullable();
            $table->json('away_starting_players')->nullable();
            $table->json('home_players_on_court')->nullable();
            $table->json('away_players_on_court')->nullable();
            $table->json('home_players')->nullable();
            $table->json('away_players')->nullable();
            $table->integer('home_timeouts_left')->default(0);
            $table->integer('away_timeouts_left')->default(0);
            $table->integer('home_fouls_left')->default(0);
            $table->integer('away_fouls_left')->default(0);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_live');
    }
};
