<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => '產品A',
            'description' => '產品A的描述',
            'price' => 100,
            'stock' => 10,
            'image' => 'path/to/imageA.jpg', // 添加圖片路徑
        ]);

        Product::create([
            'name' => '產品B',
            'description' => '產品B的描述',
            'price' => 200,
            'stock' => 20,
            'image' => 'path/to/imageB.jpg', // 添加圖片路徑
        ]);
    }
}
