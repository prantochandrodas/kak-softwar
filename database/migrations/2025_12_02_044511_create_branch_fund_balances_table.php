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
        // Schema::create('branch_fund_balances', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('branch_id')->nullable();
        //     $table->integer('fund_id')->nullable();
        //     $table->integer('bank_id')->nullable();
        //     $table->integer('account_id')->nullable();
        //     $table->decimal('balance')->nullable();
        //     $table->decimal('opening_balance')->nullable();
        //     $table->date('date')->nullable();
        //     $table->bigInteger('created_by')->nullable();
        //     $table->bigInteger('updated_by')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_fund_balances');
    }
};