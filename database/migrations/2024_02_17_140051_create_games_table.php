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
            $table->ulid('id')->primary();
            $table->unsignedInteger('external_id')->nullable()->index();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('round_id')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->string('title');
            $table->text('body')->nullable();
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
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
            $table->integer('home_score_ot1')->nullable();
            $table->integer('away_score_ot1')->nullable();
            $table->integer('home_score_ot2')->nullable();
            $table->integer('away_score_ot2')->nullable();
            $table->integer('home_score_ot3')->nullable();
            $table->integer('away_score_ot3')->nullable();
            $table->integer('home_score_ot4')->nullable();
            $table->integer('away_score_ot4')->nullable();
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
