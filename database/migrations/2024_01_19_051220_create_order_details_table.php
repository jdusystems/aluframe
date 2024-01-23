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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('profile_type_id')->nullable();
            $table->foreign('profile_type_id')->references('id')->on('profile_types');
            $table->unsignedBigInteger('window_color_id')->nullable();
            $table->foreign('window_color_id')->references('id')->on('window_colors');
            $table->unsignedBigInteger('profile_color_id');
            $table->foreign('profile_color_id')->references('id')->on('profile_colors');
            $table->unsignedBigInteger('additional_service_id')->nullable();
            $table->foreign('additional_service_id')->references('id')->on('additional_services');
            $table->unsignedBigInteger('assembly_service_id')->nullable();
            $table->foreign('assembly_service_id')->references('id')->on('assembly_services');
            $table->unsignedBigInteger('opening_type_id')->nullable();
            $table->foreign('opening_type_id')->references('id')->on('opening_types');
            $table->unsignedBigInteger('handler_type_id')->nullable();
            $table->foreign('handler_type_id')->references('id')->on('handler_types');
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->integer('quantity_right')->nullable();
            $table->integer('quantity_left')->nullable();
            $table->integer('number_of_loops')->nullable();
            $table->double('sealant_quantity')->nullable();
            $table->integer('corner_quantity')->nullable();
            $table->double('window_handler_quantity')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedDouble('price')->nullable();
            $table->double('X1')->nullable();
            $table->double('X2')->nullable();
            $table->double('Y1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
