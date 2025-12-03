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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->string('product_code')->nullable();
            $table->decimal('purchase_price', 20, 2)->nullable();
            $table->decimal('sale_price', 20, 2)->nullable();
            $table->string('barcode')->nullable();
            $table->string('shit_no')->nullable();
            $table->text('details')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
};