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
        Schema::create('pre_sales_orders_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_sale_order_id');
            $table->foreign('pre_sale_order_id')->references('id')->on('pre_sales_orders')->onDelete('cascade');
            $table->unsignedBigInteger('project_layout_id');
            $table->integer('quantity');
            //$table->foreign('project_layout_id')->references('id')->on('project_layout')->onDelete('cascade');
            //$table->foreignId('project_layout_id')->nullable()->constrained('project_layout')->onDelete('set null');
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
