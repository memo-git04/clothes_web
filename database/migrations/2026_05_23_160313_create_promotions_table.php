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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('promotion_name', 100);
            $table->text('description')->nullable();

            $table->string('discount_type'); // percent | fixed
            $table->decimal('discount_value', 15, 2);

            $table->integer('usage_limit')->nullable();
            $table->integer('current_usage')->default(0);
            $table->integer('per_user_limit')->nullable();

            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
