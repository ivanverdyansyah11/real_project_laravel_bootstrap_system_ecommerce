<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reward::create([
            'image' => 'reward_1.jpg',
            'name' => 'Panci Stainless Steel Set',
            'description' => 'Set eksklusif panci stainless steel berkualitas tinggi, dirancang untuk memenuhi kebutuhan memasak Anda sehari-hari. Dengan lapisan anti lengket dan desain ergonomis, set ini memberikan pengalaman memasak yang efisien dan menyenangkan.',
            'points_required' => '80',
        ]);

        Reward::create([
            'image' => 'reward_2.jpg',
            'name' => 'Panci Prestige Non-Stick',
            'description' => 'Panci non-stick kualitas premium dari merek terkenal, ideal untuk memasak tanpa melekat dan mudah dibersihkan. Desain modern dan tahan panas, menjadikan panci ini pilihan tepat untuk dapur Anda.',
            'points_required' => '60',
        ]);

        Reward::create([
            'image' => 'reward_3.jpg',
            'name' => 'Set Alat Masak Berbahan Ramah Lingkungan',
            'description' => 'Set panci dan peralatan masak ramah lingkungan dengan bahan yang dapat didaur ulang. Cocok untuk mereka yang peduli pada lingkungan dan ingin tetap memasak dengan gaya yang berkelanjutan.',
            'points_required' => '45',
        ]);

        Reward::create([
            'image' => 'reward_4.jpg',
            'name' => 'Panci Teknologi Inovatif',
            'description' => 'Panci dengan teknologi inovatif seperti sensor suhu otomatis dan penutup anti tumpah. Didesain untuk mempermudah proses memasak sehari-hari Anda.',
            'points_required' => '40',
        ]);

        Reward::create([
            'image' => 'reward_5.jpg',
            'name' => 'Panci Multi-Fungsi',
            'description' => 'Panci multi-fungsi yang dapat digunakan untuk merebus, mengukus, dan menggoreng. Menghemat ruang dan waktu dalam persiapan masakan Anda.',
            'points_required' => '20',
        ]);
    }
}
