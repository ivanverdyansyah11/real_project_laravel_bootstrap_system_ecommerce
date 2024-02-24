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
            'email' => 'ivanverdyansyah@gmail.com',
            'password' => bcrypt('ivan123'),
            'role' => 'super_admin',
            'status' => 1,
        ]);

        User::create([
            'email' => 'adityaprayatna@gmail.com',
            'password' => bcrypt('aditya123'),
            'role' => 'admin',
            'status' => 1,
        ]);

        User::create([
            'email' => 'aguswartawan@gmail.com',
            'password' => bcrypt('agus123'),
            'role' => 'reseller',
            'status' => 1,
        ]);

        User::create([
            'email' => 'ayuputri@gmail.com',
            'password' => bcrypt('ayu123'),
            'role' => 'reseller',
            'status' => 1,
        ]);

        User::create([
            'email' => 'andiprayoga@gmail.com',
            'password' => bcrypt('andi123'),
            'role' => 'customer',
            'status' => 1,
        ]);

        User::create([
            'email' => 'devinaputri@gmail.com',
            'password' => bcrypt('devina123'),
            'role' => 'customer',
            'status' => 1,
        ]);
    }
}
