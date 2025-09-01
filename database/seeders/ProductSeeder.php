<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(
            [
                'name' => 'Laptop',
                'price' => '15000000',
                'description' => 'Laptop gaming terbaru',
                'stock' => 10,
            ]);
        Product::create([
            'name' => 'Monitor',
            'price' => '2500000',
            'description' => 'Monitor gaming terbaru',
            'stock' => 5,
        ]);
        Product::create([
            'name' => 'Keyboard',
            'price' => '500000',
            'description' => 'Keyboard mechanical terbaru',
            'stock' => 20,
        ]);
    }
}
