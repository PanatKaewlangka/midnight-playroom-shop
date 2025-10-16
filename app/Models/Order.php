<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * นี่คือ "รายชื่อแขกที่ได้รับอนุญาต"
     * เราได้เพิ่ม 'shipping_address_snapshot' เข้าไปแล้ว
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address_snapshot', // <-- เพิ่มบรรทัดนี้
    ];

    /**
     * Get the user that owns the Order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the items for the Order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}

