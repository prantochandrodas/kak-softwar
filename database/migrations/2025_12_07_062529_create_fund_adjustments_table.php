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
        // Schema::create('fund_adjustments', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('branch_id')->nullable();
        //     $table->bigInteger('fund_id')->nullable();
        //     $table->bigInteger('bank_id')->nullable();
        //     $table->bigInteger('account_id')->nullable();
        //     $table->date('date')->nullable();
        //     $table->tinyInteger('type')->comment('1->opening,2->adjustment')->nullable();
        //     $table->decimal('amount')->nullable();
        //     $table->text('note')->nullable();
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
        Schema::dropIfExists('fund_adjustments');
    }
};
