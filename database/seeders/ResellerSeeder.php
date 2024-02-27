<?php

namespace Database\Seeders;

use App\Models\Reseller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reseller::create([
            'users_id' => 3,
            'photo_ktp' => 'photo_ktp_3.jpg',
            'name' => 'Agus Wartawan',
            'number_phone' => '08123456789',
            'origin' => 'Singaraja',
            'place_of_birth' => 'badung',
            'date_of_birth' => '2004-06-13',
            'gender' => 'L',
            'address' => 'Jl. Veteran',
        ]);

        Reseller::create([
            'users_id' => 4,
            'photo_ktp' => 'photo_ktp_4.jpg',
            'name' => 'Ayu Putri',
            'number_phone' => '08987654321',
            'origin' => 'Denpasar',
            'place_of_birth' => 'Denpasar',
            'date_of_birth' => '2003-11-09',
            'gender' => 'P',
            'address' => 'Jl. Grand Corry',
        ]);
    }
}
