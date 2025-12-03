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
        Schema::create('variant_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->integer('variant_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->decimal('stock', 20, 2)->nullable();
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
        Schema::dropIfExists('variant_stocks');
    }
};