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
        Schema::create('profile_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('price' , 15 , 2)->nullable();
            $table->integer('sort_index')->default(1);
            $table->unsignedBigInteger('calculation_type_id')->nullable();
            $table->foreign('calculation_type_id')->references('id')->on('calculation_types');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_types');
    }
};
