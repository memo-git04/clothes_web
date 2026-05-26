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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_code')->unique();
            $table->foreignId('promotion_id')
                ->nullable()
                ->constrained('promotions')
                ->nullOnDelete();
            $table->foreignId('status_id')
                ->constrained('order_statuses')
                ->cascadeOnUpdate();

            // Giá trị tiền
            $table->decimal('total_amount', 15, 2);       // tổng tiền gốc
            $table->decimal('discount_amount', 15, 2)->default(0); // giảm giá
            $table->decimal('final_amount', 15, 2);       // tiền cuối

            $table->softDeletes();
            // Index (tối ưu query)
            $table->index(['user_id', 'status_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
