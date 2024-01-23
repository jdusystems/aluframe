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
        Schema::create('opening_type_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opening_type_id')->nullable();
            $table->foreign('opening_type_id')->references('id')->on('opening_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_type_numbers');
    }
};
