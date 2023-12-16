<?php

use App\Models\ProfileColor;
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
        Schema::create('profile_details', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // Без ручки, С ручкой, Уголок, Уплотнитель
            $table->string('vendor_code')->nullable(); // Артикул
            $table->string('description')->nullable();
            $table->double('price')->nullable();
            $table->unsignedBigInteger('profile_color_id')->nullable();
            $table->foreign('profile_color_id')->references('id')->on('profile_colors');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_details');
    }
};
