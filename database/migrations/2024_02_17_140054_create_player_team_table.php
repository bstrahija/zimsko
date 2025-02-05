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

        Schema::create('player_team', function (Blueprint $table) {
            $table->foreignId('player_id')->index()->cascadeOnDelete();
            $table->foreignId('team_id')->index()->cascadeOnDelete();
            $table->string('position')->nullable()->index();
            $table->string('number')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_team');
    }
};
