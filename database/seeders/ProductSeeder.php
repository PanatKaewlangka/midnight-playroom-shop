<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // <-- Import Category Model
use App\Models\Product;  // <-- Import Product Model

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. สร้างหมวดหมู่ตัวอย่างขึ้นมาก่อน
        $category = Category::create([
            'name' => 'Board Games'
        ]);

        // 2. สร้างสินค้าตัวอย่าง 3 ชิ้น โดยให้อยู่ในหมวดหมู่ข้างบน
        Product::create([
            'category_id' => $category->category_id,
            'name' => 'Catan',
            'description' => 'A classic game of settlement, trade, and resource management.',
            'price' => 49.99,
            'stock_quantity' => 20,
            'image_url' => 'https://via.placeholder.com/400x300.png/004466?text=Catan'
        ]);

        Product::create([
            'category_id' => $category->category_id,
            'name' => 'Ticket to Ride',
            'description' => 'A cross-country train adventure where players collect cards of various types of train cars.',
            'price' => 54.99,
            'stock_quantity' => 15,
            'image_url' => 'https://via.placeholder.com/400x300.png/882211?text=Ticket+to+Ride'
        ]);

        Product::create([
            'category_id' => $category->category_id,
            'name' => 'Codenames',
            'description' => 'A social word game with a simple premise and challenging gameplay.',
            'price' => 19.99,
            'stock_quantity' => 30,
            'image_url' => 'https://via.placeholder.com/400x300.png/227755?text=Codenames'
        ]);
    }
}