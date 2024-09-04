<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->nullable();
            $table->enum('product_type', ['simple', 'parent', 'subcategory']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price',10, 2)->nullable();
            $table->decimal('discount')->nullable();
            $table->string('currency', 30);
            $table->boolean('visible');
            $table->timestamps(); # created_at and updated_at columns
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