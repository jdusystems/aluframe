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
        Schema::create('window_colors', function (Blueprint $table) {
            $table->id();
            $table->string('image_name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('name')->nullable();
            $table->string('vendor_code')->nullable(); // Артикул
            $table->double('price' , 15 ,2)->nullable();
            $table->integer('sort_index')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('window_colors');
    }
};
