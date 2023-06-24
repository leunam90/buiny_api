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
            $table->date('transaction_date');
            $table->integer('document_number');
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
