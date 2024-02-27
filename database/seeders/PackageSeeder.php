<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'products_id' => 1,
            'name' => 'Paket Bahagia',
            'quantity' => 12,
            'selling_price' => 95000,
        ]);

        Package::create([
            'products_id' => 1,
            'name' => 'Paket Sejahtera',
            'quantity' => 24,
            'selling_price' => 90000,
        ]);

        Package::create([
            'products_id' => 1,
            'name' => 'Paket Berkelimpahan',
            'quantity' => 108,
            'selling_price' => 85000,
        ]);

        Package::create([
            'products_id' => 2,
            'name' => 'Sehat',
            'quantity' => 3,
            'selling_price' => 190000,
        ]);

        Package::create([
            'products_id' => 2,
            'name' => 'Segar',
            'quantity' => 6,
            'selling_price' => 185000,
        ]);

        Package::create([
            'products_id' => 2,
            'name' => 'Bugar',
            'quantity' => 12,
            'selling_price' => 180000,
        ]);

        Package::create([
            'products_id' => 2,
            'name' => 'Sempurna',
            'quantity' => 24,
            'selling_price' => 175000,
        ]);

        Package::create([
            'products_id' => 3,
            'quantity' => 3,
            'selling_price' => 125000,
        ]);

        Package::create([
            'products_id' => 3,
            'quantity' => 10,
            'selling_price' => 120000,
        ]);

        Package::create([
            'products_id' => 3,
            'quantity' => 20,
            'selling_price' => 115000,
        ]);
    }
}
