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
        Schema::create('additional_service_order_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('order_detail_id');
            $table->unsignedBigInteger('additional_service_id');
            $table->decimal('price' , 10 , 2)->default(0);
            $table->foreign('order_detail_id')->references('id')->on('order_details');
            $table->foreign('additional_service_id')->references('id')->on('additional_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_service_order_detail');
    }
};
