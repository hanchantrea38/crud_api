<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Mobile',
            'is_active' => false,
        ]);

        Category::create([
            'name' => 'Laptop',
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Mango',
            'is_active' => true,
        ]);
    }
}
