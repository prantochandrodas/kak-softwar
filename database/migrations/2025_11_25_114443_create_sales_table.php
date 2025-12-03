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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('total_amount', 20, 2)->nullable();
            $table->decimal('paid_amount', 20, 2)->nullable();
            $table->decimal('due_amount', 20, 2)->nullable();
            $table->decimal('discount', 20, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};