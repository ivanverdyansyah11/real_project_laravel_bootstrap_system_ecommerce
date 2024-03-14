<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'super.admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'super_admin',
            'status' => 1,
        ]);

        User::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'status' => 1,
        ]);

        User::create([
            'email' => 'reseller2@gmail.com',
            'password' => bcrypt('reseller2'),
            'role' => 'reseller',
            'status' => 1,
        ]);

        User::create([
            'email' => 'reseller1@gmail.com',
            'password' => bcrypt('reseller1'),
            'role' => 'reseller',
            'status' => 1,
        ]);

        User::create([
            'email' => 'customer2@gmail.com',
            'password' => bcrypt('customer2'),
            'role' => 'customer',
            'status' => 1,
        ]);

        User::create([
            'email' => 'customer1@gmail.com',
            'password' => bcrypt('customer1'),
            'role' => 'customer',
            'status' => 1,
        ]);
    }
}
