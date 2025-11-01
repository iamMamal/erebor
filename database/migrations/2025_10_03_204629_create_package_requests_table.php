<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // کاربر
            $table->foreignId('package_id')->constrained()->onDelete('cascade'); // پکیج
            $table->enum('status', ['pending', 'approved', 'rejected', 'done'])->default('pending'); // وضعیت درخواست
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_requests');
    }
};
