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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id'); // PK

            // Foreign Keys
            $table->foreignId('order_id')->constrained('orders', 'order_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');

            $table->integer('quantity'); // INT จำนวนสินค้าที่สั่ง
            $table->decimal('price_at_purchase', 8, 2); // DECIMAL ราคา ณ เวลาที่ซื้อ
            
            // ไม่ต้องใช้ timestamps() ในตารางนี้
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};