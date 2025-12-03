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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('total_amount', 20, 2)->nullable();
            $table->decimal('discount', 20, 2)->nullable();
            $table->decimal('final_amount', 20, 2)->nullable();
            $table->decimal('due_amount', 20, 2)->nullable();
            $table->decimal('paid_amount', 20, 2)->nullable();
            $table->decimal('transporation_cost', 20, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};