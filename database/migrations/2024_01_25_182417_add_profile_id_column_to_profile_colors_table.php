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
        Schema::table('profile_colors', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_type_id');
            $table->foreign('profile_type_id')->references('id')->on('profile_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_colors', function (Blueprint $table) {
            //
        });
    }
};
