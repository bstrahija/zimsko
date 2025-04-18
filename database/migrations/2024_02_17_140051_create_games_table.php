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
        Schema::disableForeignKeyConstraints();

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('external_id')->nullable()->index();
            $table->foreignId('event_id')->nullable()->constrained('events')->cascadeOnDelete();
            $table->foreignId('round_id')->nullable()->constrained('rounds');
            $table->string('status', 50)->nullable()->default('scheduled')->index();
            $table->string('slug')->nullable()->index();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->foreignId('home_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('away_team_id')->nullable()->constrained('teams')->cascadeOnDelete();

            // Add stats columns
            foreach (config('stats.columns') as $column) {
                foreach (['home', 'away'] as $side) {
                    $table->{$column['type'] ?? 'integer'}($side . '_' . $column['id'])->nullable()->default(0);
                }
            }

            // More "Live" columns
            $table->integer('period')->default(1);
            $table->json('home_starting_players')->nullable();
            $table->json('away_starting_players')->nullable();
            $table->json('home_players_on_court')->nullable();
            $table->json('away_players_on_court')->nullable();
            $table->integer('home_timeouts_left')->default(0);
            $table->integer('away_timeouts_left')->default(0);
            $table->integer('home_fouls_left')->default(0);
            $table->integer('away_fouls_left')->default(0);

            // Other
            $table->json('data')->nullable();
            $table->string('type', 50)->default('default')->index();
            $table->dateTime('scheduled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
