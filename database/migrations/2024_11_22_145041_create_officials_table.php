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
        Schema::create('officials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('slug')->nullable()->index();
            $table->string('name');
            $table->text('body')->nullable();
            $table->string('position')->default('organizer')->nullable();
            $table->date('birthday')->nullable();
            $table->string('status', 50)->nullable()->default('active')->index();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
