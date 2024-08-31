<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => '產品1',
            'description' => '這是一個示例產品。',
            'price' => 100.00,
            'stock' => 10
        ]);

        Product::create([
            'name' => '產品2',
            'description' => '這是一個示例產品。',
            'price' => 150.00,
            'stock' => 5
        ]);

        Product::create([
            'name' => '產品3',
            'description' => '這是一個示例產品。',
            'price' => 200.00,
            'stock' => 8
        ]);
    }
}
