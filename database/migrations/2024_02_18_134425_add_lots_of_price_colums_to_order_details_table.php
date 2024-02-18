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
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('profile_price')->default(0.00)->after('comment');
            $table->decimal('corner_price')->default(0.00)->after('profile_price');
            $table->decimal('sealant_price')->default(0.00)->after('corner_price');
            $table->decimal('window_handler_price')->default(0.00)->after('sealant_price');
            $table->decimal('window_price')->default(0.00)->after('window_handler_price');
            $table->decimal('assembly_service_price')->default(0.00)->after('window_price');
            $table->decimal('additional_service_price')->default(0.00)->after('assembly_service_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            //
        });
    }
};
