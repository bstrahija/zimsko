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
            $table->foreignId('event_id')->cascadeOnDelete();
            $table->foreignId('game_id')->cascadeOnDelete();
            $table->foreignId('player_id')->cascadeOnDelete();
            $table->foreignId('team_id')->cascadeOnDelete();

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
        Schema::dropIfExists('game_player');
    }
};
