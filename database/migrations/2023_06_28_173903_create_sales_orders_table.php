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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_sales_order_id')->nullable();
            $table->foreign('pre_sales_order_id')->references('id')->on('pre_sales_orders')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->nullable();
            //$table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
            $table->timestamp('transaction_date');
            $table->string('transaction_number');
            $table->integer('document_number');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('installation_place')->nullable();
            $table->string('caudal')->nullable();
            $table->string('fluent_origin')->nullable();
            $table->string('use_of_treated_water')->nullable();
            $table->boolean('add_ptar_plans')->default(true);
            $table->boolean('installation_place_plans')->default(true);
            $table->string('observation')->nullable();
            $table->string('internal_status')->default('pending');
            $table->string('status')->default('pending');
            $table->decimal('amount');
            $table->decimal('tax_amount');
            $table->decimal('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
