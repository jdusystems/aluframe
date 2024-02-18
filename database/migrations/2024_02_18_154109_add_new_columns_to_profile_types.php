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
        Schema::table('profile_types', function (Blueprint $table) {
            $table->string('uz_name')->nullable();
            $table->string('size_name')->nullable();
            $table->double('thickness')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_types', function (Blueprint $table) {
            //
        });
    }
};
