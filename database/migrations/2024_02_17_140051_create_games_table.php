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
            $table->integer('home_score_p1')->nullable()->default(0);
            $table->integer('away_score_p1')->nullable()->default(0);
            $table->integer('home_score_p2')->nullable()->default(0);
            $table->integer('away_score_p2')->nullable()->default(0);
            $table->integer('home_score_p3')->nullable()->default(0);
            $table->integer('away_score_p3')->nullable()->default(0);
            $table->integer('home_score_p4')->nullable()->default(0);
            $table->integer('away_score_p4')->nullable()->default(0);
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
