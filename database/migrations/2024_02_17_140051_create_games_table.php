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
            $table->foreignId('event_id')->cascadeOnDelete();
            $table->foreignId('round_id')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->foreignId('home_team_id')->nullable()->constrained('teams');
            $table->foreignId('away_team_id')->nullable()->constrained('teams');

            foreach (config('stats.columns') as $column) {
                foreach (['home', 'away'] as $side) {
                    $table->{$column['type'] ?? 'integer'}($side . '_' . $column['id'])->nullable()->default(0);
                }
            }

            $table->string('status', 50)->nullable()->default('pending')->index();
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
