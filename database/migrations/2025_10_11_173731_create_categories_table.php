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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); // <-- PK, INT, Auto-increment
            $table->string('name')->unique(); // <-- VARCHAR, UNIQUE
            // Laravel จะสร้าง created_at และ updated_at ให้เองอัตโนมัติ
            // ไม่ต้องใส่ $table->timestamps(); เพราะเราไม่ได้ใช้ใน Schema ฉบับย่อ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};