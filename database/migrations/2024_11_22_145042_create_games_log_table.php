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
        Schema::create('games_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->string('type')->index()->nullable();
            $table->string('subtype')->index()->nullable();
            $table->integer('amount')->index()->default(0)->nullable();
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->integer('period')->index()->default(1);
            $table->string('player_name')->nullable();
            $table->string('player_2_name')->nullable();
            $table->string('team_name')->nullable();
            $table->string('team_side')->index()->nullable();
            $table->foreignId('player_id')->index()->nullable()->constrained('players');
            $table->foreignId('player_2_id')->index()->nullable()->constrained('players');
            $table->foreignId('team_id')->index()->nullable()->constrained('teams');
            $table->foreignId('coach_id')->index()->nullable()->constrained('coaches');
            $table->foreignId('official_id')->index()->nullable()->constrained('officials');
            $table->string('location')->nullable(); // Coordinates on the court, displayed as percentages
            $table->json('data')->nullable();
            $table->text('summary')->nullable();
            $table->string('occurred_at')->default('00:00:00')->nullable();
            $table->string('occurred_at_p')->default('00:00:00')->nullable(); // This will be the elapsed time in second since the start of the game
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games_log');
    }
};
