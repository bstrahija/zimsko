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

            // Get main columns
            foreach (config('stats.columns') as $column) {
                $type = $column['type'] ?? 'integer';
                $table->$type($column['id'])->nullable()->default(0);
            }

            // Get columns for calculation
            foreach (config('stats.calculated_columns') as $column) {
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
        Schema::dropIfExists('stats');
    }
};
