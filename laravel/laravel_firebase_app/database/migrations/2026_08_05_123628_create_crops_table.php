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
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name');
            $table->string('crop_season');
            $table->string('crop_type');
            $table->text('variety');
            $table->text('sowing_method');
            $table->text('irrigation');
            $table->text('fertilizers');
            $table->text('plant_protection');
            $table->text('deficiency');
            $table->text('weeds');
            $table->text('advisory');
            $table->string('crop_image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
