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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم محصول
            $table->text('description')->nullable(); // توضیحات
            $table->unsignedInteger('price'); // قیمت (بر اساس امتیاز)
            $table->string('image')->nullable(); // عکس محصول
            $table->boolean('is_active')->default(true); // فعال/غیرفعال بودن
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
