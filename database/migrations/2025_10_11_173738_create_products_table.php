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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); // PK
            
            // Foreign Key ที่เชื่อมไปยังตาราง categories
            $table->foreignId('category_id')->constrained('categories', 'category_id');
            
            $table->string('name'); // VARCHAR
            $table->text('description'); // TEXT สำหรับข้อความยาวๆ
            $table->decimal('price', 8, 2); // DECIMAL สำหรับเก็บราคา (รวม 8 หลัก, ทศนิยม 2 ตำแหน่ง)
            $table->integer('stock_quantity'); // INT สำหรับจำนวนสินค้า
            $table->string('image_url')->nullable(); // VARCHAR และอนุญาตให้เป็นค่าว่างได้ (nullable)
            $table->timestamps(); // สร้าง created_at และ updated_at อัตโนมัติ
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