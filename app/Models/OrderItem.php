<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_item_id';
    protected $table = 'order_items';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * นี่คือ "รายชื่อแขกที่ได้รับอนุญาต"
     * เราได้เพิ่ม 'price_at_purchase' เข้าไปแล้ว
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_purchase', // <-- เพิ่มบรรทัดนี้
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
}

