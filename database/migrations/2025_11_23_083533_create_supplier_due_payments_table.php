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
        Schema::create('supplier_due_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->bigInteger('fund_id')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->date('date')->nullable();
            $table->integer('branch_id')->nullable();
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
        Schema::dropIfExists('supplier_due_payments');
    }
};
