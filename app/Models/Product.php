<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    /**
     * คำนวณคะแนนรีวิวเฉลี่ยของสินค้านี้
     * นี่คือฟังก์ชันใหม่ที่เราเพิ่มเข้าไป
     */
    public function averageRating(): float
    {
        // ใช้ relationship 'reviews()' ที่เรามีอยู่แล้ว
        // แล้วหาค่าเฉลี่ยของคอลัมน์ 'rating'
        // round() เพื่อปัดเศษทศนิยมให้สวยงาม (เช่น 4.5)
        return round($this->reviews()->avg('rating'), 1);
    }

    public function orderItems() // *** เพิ่มฟังก์ชันนี้ ***
    {
        // ตรวจสอบว่าใช้คีย์ถูกต้อง: OrderItem::class, Foreign Key ชื่อ 'product_id', Primary Key ใน Product ชื่อ 'product_id'
        return $this->hasMany(\App\Models\OrderItem::class, 'product_id', 'product_id');
    }
    
}

