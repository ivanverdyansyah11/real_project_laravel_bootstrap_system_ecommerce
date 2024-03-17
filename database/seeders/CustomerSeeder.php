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
            'email' => 'andiprayoga@gmail.com',
            'image' => 'profile_image_5.jpg',
            'photo_ktp' => 'photo_ktp_5.jpg',
            'name' => 'Andi Prayoga',
            'number_phone' => '08975312468',
            'origin' => 'Gianyar',
            'place_of_birth' => 'Karangasem',
            'date_of_birth' => '2002-08-26',
            'gender' => 'L',
            'address' => 'Jl. Ahmad Yani',
        ]);

        Customer::create([
            'email' => 'devinaputri@gmail.com',
            'image' => 'profile_image_6.jpg',
            'photo_ktp' => 'photo_ktp_6.jpg',
            'name' => 'Devina Putri',
            'number_phone' => '082468975431',
            'origin' => 'Karangasem',
            'place_of_birth' => 'Denpasar',
            'date_of_birth' => '2005-10-29',
            'gender' => 'P',
            'address' => 'Jl. Dalung Permai',
        ]);
    }
}
