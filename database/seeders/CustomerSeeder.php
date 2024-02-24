<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'users_id' => 5,
            'name' => 'Andi Prayoga',
            'number_phone' => '08975312468',
            'photo_ktp' => 'photo_ktp_3.jpg',
        ]);

        Customer::create([
            'users_id' => 6,
            'name' => 'Devina Putri',
            'number_phone' => '082468975431',
            'photo_ktp' => 'photo_ktp_4.jpg',
        ]);
    }
}
