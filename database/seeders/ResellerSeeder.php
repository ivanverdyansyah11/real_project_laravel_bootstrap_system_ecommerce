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
            'name' => 'Agus Wartawan',
            'number_phone' => '08123456789',
            'photo_ktp' => 'photo_ktp_1.jpg',
        ]);

        Reseller::create([
            'users_id' => 4,
            'name' => 'Ayu Putri',
            'number_phone' => '08987654321',
            'photo_ktp' => 'photo_ktp_2.jpg',
        ]);
    }
}
