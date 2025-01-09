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
            $table->string('type')->default('game')->nullable()->index();
            $table->string('for')->default('team')->nullable()->index();
            $table->foreignId('event_id')->nullable()->cascadeOnDelete();
            $table->foreignId('game_id')->nullable()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->cascadeOnDelete();
            $table->foreignId('player_id')->nullable()->cascadeOnDelete();
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
