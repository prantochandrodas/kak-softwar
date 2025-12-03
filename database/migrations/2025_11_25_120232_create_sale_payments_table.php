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
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id')->nullable();
            $table->bigInteger('fund_id')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_payments');
    }
};