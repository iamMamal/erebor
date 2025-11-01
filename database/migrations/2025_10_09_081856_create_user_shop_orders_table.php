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
        Schema::create('user_shop_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // کاربر
            $table->json('products'); // JSON: [ {"product_id": 1, "quantity": 3}, {"product_id": 2, "quantity": 2} ]
            $table->string('status')->default('pending'); // وضعیت سفارش: pending, confirmed, processing, delivered
            $table->boolean('confirmed')->default(false); // تایید خرید و کم شدن امتیاز
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shop_orders');
    }
};
