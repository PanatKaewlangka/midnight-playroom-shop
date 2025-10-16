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
            $table->id('order_id'); // PK

            // Foreign Key
            $table->foreignId('user_id')->constrained('users', 'id');

            $table->string('status')->default('pending'); // VARCHAR, 'pending', 'paid', 'shipped'
            $table->decimal('total_amount', 10, 2); // DECIMAL (รวม 10 หลัก, ทศนิยม 2)
            $table->text('shipping_address_snapshot'); // TEXT สำหรับเก็บข้อมูลที่อยู่ทั้งหมด
            $table->timestamps(); // order_date จะใช้ created_at แทน
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