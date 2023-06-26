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
        Schema::create('pre_sales_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('transaction_date');
            $table->string('transaction_number');
            $table->integer('document_number');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('pre_sales_orders');
    }
};
