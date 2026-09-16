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
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->foreign('crop_id')->references('id')->on('crops')->onDelete('restrict');
            $table->unique(['crop_id', 'seed_name']);
            $table->string('seed_name');
            $table->string('seed_type');
            $table->integer('maturity_days');
            $table->string('season');
            $table->text('seed_description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeds');
    }
};
