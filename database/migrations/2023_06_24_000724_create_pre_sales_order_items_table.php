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
        Schema::create('pre_sales_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_sales_orders_id');
            $table->foreign('pre_sales_orders_id')->references('id')->on('pre_sales_orders')->onDelete('cascade');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('project_layout')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_sales_order_items');
    }
};
