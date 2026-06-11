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
            'desc' => 'mobile description',
            'is_active' => false,
        ]);

        Category::create([
            'name' => 'Laptop',
            'desc' => 'Laptop description',
            'is_active' => true,
        ]);
    }
}
