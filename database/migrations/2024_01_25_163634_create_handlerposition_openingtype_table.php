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
        Schema::create('handlerposition_openingtype', function (Blueprint $table) {
            $table->unsignedBigInteger('handler_position_id');
            $table->foreign('handler_position_id')->references('id')->on('handler_positions');

            $table->unsignedBigInteger('opening_type_id');
            $table->foreign('opening_type_id')->references('id')->on('opening_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handlerposition_openingtype');
    }
};
