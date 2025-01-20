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

        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('external_id')->nullable()->index();
            $table->foreignId('event_id')->cascadeOnDelete();
            $table->string('slug')->nullable()->index();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->string('status', 50)->default('active')->index();
            $table->json('data')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->string('type', 50)->default('default')->index();
            $table->string('subtype', 20)->nullable()->index();
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
        Schema::dropIfExists('rounds');
    }
};
