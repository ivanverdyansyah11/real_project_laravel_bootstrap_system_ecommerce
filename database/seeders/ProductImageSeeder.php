<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductImage::create([
            'products_id' => 1,
            'image' => 'minyak_dewantari.jpg',
            'status' => 0,
        ]);

        ProductImage::create([
            'products_id' => 1,
            'image' => 'minyak_dewantari_sample.jpg',
            'status' => 1,
        ]);

        ProductImage::create([
            'products_id' => 2,
            'image' => 'ramuan_diksa.jpg',
            'status' => 1,
        ]);

        ProductImage::create([
            'products_id' => 2,
            'image' => 'ramuan_diksa_sample.jpg',
            'status' => 0,
        ]);

        ProductImage::create([
            'products_id' => 3,
            'image' => 'kapsul_visnhu.jpg',
            'status' => 1,
        ]);

        ProductImage::create([
            'products_id' => 3,
            'image' => 'kapsul_visnhu.jpg',
            'status' => 0,
        ]);
    }
}
