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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->integer('event_id')->index();
            $table->integer('game_id')->nullable()->index();
            $table->integer('team_id')->nullable()->index();
            $table->string('player_id')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->index()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
