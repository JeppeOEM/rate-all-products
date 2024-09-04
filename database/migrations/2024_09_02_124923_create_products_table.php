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
            $table->string('category', 12 ); // 'simple', overvariant, undervariant
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('vendor');
            $table->text('description')->nullable();
            $table->decimal('price');
            $table->decimal('cost_price')->nullable();
            $table->decimal('discount')->nullable();
            $table->string('currency', 60);
            $table->boolean('visible')->default(true);
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