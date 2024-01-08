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
        Schema::create('profile_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_name')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('sort_index');
            $table->string('color_from');
            $table->string('color_to');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_colors');
    }
};
