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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('transfer_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('varient_id')->nullable();
            $table->decimal('quantity', 20, 2)->nullable();
            $table->decimal('rate', 20, 2)->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_details');
    }
};