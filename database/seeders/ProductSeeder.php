<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'categories_id' => 1,
            'name' => 'Minyak Dewantari',
            'image' => 'minyak_dewantari.jpg',
            // 'image' => 'minyak_dewantari_sample.jpg',
            'description' => 'Minyak Dewantari adalah produk perawatan kulit eksklusif yang menggabungkan bahan alami berkualitas tinggi, seperti minyak esensial lavender, chamomile, dan tea tree, untuk memberikan perawatan mendalam dan menyeluruh. Diperkaya dengan ekstrak herbal pilihan, produk ini tidak hanya memberikan kelembapan optimal tetapi juga menawarkan aroma menenangkan yang merelaksasi. Cocok untuk semua jenis kulit, Minyak Dewantari memberikan pengalaman perawatan kulit yang unik dan menyegarkan, sambil menekankan keberlanjutan dengan kemasan elegan dan desain ramah lingkungan. Produk ini tidak hanya mendukung kecantikan alami tetapi juga merayakan perpaduan antara keajaiban alam dan teknologi modern dalam merawat kulit Anda.',
            'unit' => 'box',
            'stock' => 350,
            'purchase_price' => 135000,
            'selling_price' => 135000,
        ]);

        Product::create([
            'categories_id' => 1,
            'name' => 'Ramuan Diksa',
            'image' => 'ramuan_diksa.jpg',
            'description' => 'Ramuan Diksa adalah ramuan alami yang memadukan kekayaan rempah-rempah pilihan untuk memberikan pengalaman kesehatan dan kebugaran yang holistik. Diracik dengan cermat menggunakan bahan-bahan herbal tradisional, Ramuan Diksa menawarkan manfaat positif bagi tubuh dan jiwa. Kombinasi unik dari jahe, kunyit, temulawak, dan rempah-rempah lainnya memberikan dukungan untuk meningkatkan daya tahan tubuh, memperkuat sistem pencernaan, dan merangsang energi vital. Ramuan ini tidak hanya menyajikan rasa yang lezat tetapi juga memberikan keharmonisan bagi tubuh secara keseluruhan. Ramuan Diksa cocok untuk digunakan sebagai suplemen kesehatan sehari-hari, membawa Anda pada perjalanan kesehatan yang alami dan menyeluruh. Temukan keajaiban ramuan tradisional dengan Ramuan Diksa, pilihan terbaik untuk meningkatkan kesehatan Anda secara alami.',
            'unit' => 'pcs',
            'stock' => 210,
            'purchase_price' => 135000,
            'selling_price' => 55000,
        ]);

        Product::create([
            'categories_id' => 1,
            'name' => 'Kapsul Visnhu',
            'image' => 'kapsul_visnhu.jpg',
            'description' => 'Kapsul Vishnu adalah inovasi terkini dalam perawatan kesehatan yang menyajikan solusi holistik untuk meningkatkan kesejahteraan Anda. Dirancang dengan cermat menggunakan formula yang terdiri dari bahan-bahan alami pilihan, Kapsul Vishnu menggabungkan kebijaksanaan warisan tradisional dengan kemajuan ilmiah modern. Kapsul ini mengandung campuran unik vitamin, mineral, dan ekstrak tumbuhan yang secara sinergis bekerja untuk mendukung sistem kekebalan tubuh, meningkatkan energi, dan menjaga keseimbangan nutrisi. Dengan konsep yang berfokus pada keharmonisan tubuh dan pikiran, Kapsul Vishnu tidak hanya memberikan manfaat kesehatan fisik tetapi juga mendukung kesejahteraan mental Anda. Ambil langkah menuju gaya hidup sehat dan seimbang dengan Kapsul Vishnu, pilihan terbaik untuk merawat tubuh secara menyeluruh.',
            'unit' => 'pcs',
            'stock' => 12,
            'purchase_price' => 135000,
            'selling_price' => 100000,
        ]);
    }
}
