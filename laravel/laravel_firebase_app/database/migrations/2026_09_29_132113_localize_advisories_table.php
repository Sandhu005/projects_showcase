<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advisories', function (Blueprint $table) {
            $table->string('title_en')->after('state');
            $table->string('title_hi')->after('title_en');

            $table->text('description_en')->after('title_hi');
            $table->text('description_hi')->after('description_en');

            $table->dropColumn([
                'title',
                'description',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('advisories', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->dropColumn([
                'title_en',
                'title_hi',
                'description_en',
                'description_hi',
            ]);
        });
    }
};
