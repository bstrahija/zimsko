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
        /**
         * Creates the game_team table.
         *
         * This table stores the stats for a team in a game.
         *
         * @param Blueprint $table
         */
        Schema::create('game_team', function (Blueprint $table) {
            $table->id();
            $table->string('game_id')->constrained('games')->cascadeOnDelete()->index();
            $table->string('team_id')->nullable()->constrained('teams')->cascadeOnDelete()->index();

            // Get number columns
            foreach (config('stats.columns') as $column) {
                $type = $column['type'] ?? 'integer';
                $table->$type($column['id'])->nullable()->default(0);
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_team');
    }
};
