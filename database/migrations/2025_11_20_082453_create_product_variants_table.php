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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('size_id')->nullable();
            $table->bigInteger('color_id')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('stock', 20, 2)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
