<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     * ระบุให้ Laravel รู้ว่า PK ของตารางนี้คือ 'category_id' ไม่ใช่ 'id'
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * Indicates if the model should be timestamped.
     * ตารางนี้ไม่มี created_at, updated_at
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
