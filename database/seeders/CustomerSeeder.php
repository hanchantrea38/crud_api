<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'phone' => '555-0101',
            'gender' => 'Male',
        ]);

        Customer::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@example.com',
            'phone' => '555-0102',
            'gender' => 'Female',
        ]);

        Customer::create([
            'name' => 'Michael Brown',
            'email' => 'michael.brown@example.com',
            'phone' => '555-0103',
            'gender' => 'Male',
        ]);

        Customer::create([
            'name' => 'Emma Davis',
            'email' => 'emma.davis@example.com',
            'phone' => '555-0104',
            'gender' => 'Female',
        ]);

        Customer::create([
            'name' => 'Robert Wilson',
            'email' => 'robert.wilson@example.com',
            'phone' => '555-0105',
            'gender' => 'Male',
        ]);
    }
}
