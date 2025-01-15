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
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->integer('home_score_p1')->default(0);
            $table->integer('away_score_p1')->default(0);
            $table->integer('home_score_p2')->default(0);
            $table->integer('away_score_p2')->default(0);
            $table->integer('home_score_p3')->default(0);
            $table->integer('away_score_p3')->default(0);
            $table->integer('home_score_p4')->default(0);
            $table->integer('away_score_p4')->default(0);
            $table->integer('home_score_p5')->nullable();
            $table->integer('away_score_p5')->nullable();
            $table->integer('home_score_p6')->nullable();
            $table->integer('away_score_p6')->nullable();
            $table->integer('home_score_p7')->nullable();
            $table->integer('away_score_p7')->nullable();
            $table->integer('home_score_p8')->nullable();
            $table->integer('away_score_p8')->nullable();
            $table->integer('home_score_p9')->nullable();
            $table->integer('away_score_p9')->nullable();
            $table->integer('home_score_p10')->nullable();
            $table->integer('away_score_p10')->nullable();
            $table->integer('period')->default(1);
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
