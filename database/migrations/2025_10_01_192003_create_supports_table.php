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
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('instagram')->nullable(); // لینک اینستاگرام
            $table->string('phone')->nullable();     // شماره موبایل
            $table->string('chat_link')->nullable(); // لینک واتساپ / تلگرام
            $table->boolean('is_active')->default(true); // فعال یا غیرفعال
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
