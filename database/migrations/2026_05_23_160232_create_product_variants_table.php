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
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('size_id')->constrained('sizes')->cascadeOnDelete();
            $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();

            $table->string('sku', 100)->unique();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('base_price', 15, 2); // Giá gốc của sản phẩm
            $table->decimal('selling_price', 15, 2); // Giá bán hiện tại của sản phẩm
            $table->decimal('original_price', 15, 2)->nullable(); // Giá gốc ban đầu của sản phẩm, có thể null nếu không có giảm giá

            $table->softDeletes();
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
