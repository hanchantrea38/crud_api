<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'iPhone 15 Pro',
            'description' => 'Latest Apple smartphone with advanced features',
            'price' => 999.99,
            'qty' => 50,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S24',
            'description' => 'Flagship Android device with excellent camera',
            'price' => 899.99,
            'qty' => 45,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'MacBook Pro 16',
            'description' => 'Powerful laptop for professionals',
            'price' => 2499.99,
            'qty' => 20,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Dell XPS 15',
            'description' => 'Premium Windows laptop with excellent performance',
            'price' => 1899.99,
            'qty' => 30,
            'category_id' => 2,
        ]);
    }
}
