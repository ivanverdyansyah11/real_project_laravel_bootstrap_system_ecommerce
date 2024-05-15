<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipping::create([
            'address' => 'Jl. Kartini No.102, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80231, Indonesia',
            'shipping_price' => 10000,
        ]);
    }
}
