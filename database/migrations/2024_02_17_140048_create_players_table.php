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

        Schema::create('players', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->unsignedInteger('external_id')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->string('name');
            $table->text('body')->nullable();
            $table->string('position')->nullable()->index();
            $table->integer('number')->nullable();
            $table->date('birthday')->nullable();
            $table->string('status', 50)->default('active')->index();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('players');
    }
};
