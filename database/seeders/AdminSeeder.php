<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'users_id' => 1,
            'photo_ktp' => 'photo_ktp_1.jpg',
            'name' => 'Ivan Verdyansyah',
            'number_phone' => '0812376574565',
            'origin' => 'Badung',
            'place_of_birth' => 'Denpasar',
            'date_of_birth' => '2005-02-09',
            'gender' => 'L',
            'address' => 'Jl. Monang Maning',
        ]);

        Admin::create([
            'users_id' => 2,
            'photo_ktp' => 'photo_ktp_2.jpg',
            'name' => 'Aditya Prayatna',
            'number_phone' => '083453545554',
            'origin' => 'Klungkung',
            'place_of_birth' => 'Badung',
            'date_of_birth' => '2006-01-15',
            'gender' => 'L',
            'address' => 'Jl. Imam Bonjol',
        ]);
    }
}
