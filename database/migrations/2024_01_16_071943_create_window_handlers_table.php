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
        Schema::create('window_handlers', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code')->nullable();
            $table->string('name')->nullable();
            $table->double('price' , 15 , 2)->nullable();
            $table->unsignedBigInteger('profile_type_id')->nullable();
            $table->foreign('profile_type_id')->references('id')->on('profile_types');
            $table->unsignedBigInteger('profile_color_id')->nullable();
            $table->foreign('profile_color_id')->references('id')->on('profile_colors');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('window_handlers');
    }
};
