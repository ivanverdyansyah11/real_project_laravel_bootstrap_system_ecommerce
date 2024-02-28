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
            'name' => 'Tiket ke Thailand',
            'description' => 'Penghargaan istimewa yang membawa Anda pada petualangan tak terlupakan ke destinasi eksotis di Asia Tenggara. Dengan kupon ini, Anda akan merasakan pesona budaya yang kaya, keindahan alam yang memukau, dan keramahan penduduk setempat yang hangat. Terdapat pengalaman menyelam dalam keindahan sejarah kuno, mengeksplorasi pasar tradisional yang berwarna-warni, dan menikmati kuliner autentik yang memanjakan lidah Anda. Sebuah tiket ke Thailand bukan hanya perjalanan, tetapi juga serangkaian momen magis yang akan mengisi kenangan Anda dengan kebahagiaan dan keindahan yang tak terlupakan. Selamat menikmati petualangan unik yang akan membawa Anda lebih dekat dengan pesona Thailand.',
            'points_required' => '400',
        ]);

        Reward::create([
            'image' => 'reward_2.jpg',
            'name' => 'Tiket ke Swiss',
            'description' => 'Perjalanan menakjubkan ke negeri yang dikenal dengan keindahan alamnya yang spektakuler dan ketenangan yang memukau. Dengan kupon ini, Anda akan memiliki kesempatan untuk menjelajahi pegunungan Alpen yang menakjubkan, danau yang jernih, dan desa-desa yang memesona. Nikmati suasana damai dan keindahan alam yang luar biasa sambil menikmati kemewahan dan kenyamanan Swiss yang terkenal. Dari pemandangan alam yang menakjubkan hingga kekayaan budaya dan arsitektur yang elegan, kupon ini adalah undangan untuk mengeksplorasi keindahan Swiss yang memikat dan menciptakan kenangan liburan yang tak terlupakan. Selamat menikmati petualangan eksklusif ke destinasi penuh pesona ini.',
            'points_required' => '500',
        ]);

        Reward::create([
            'image' => 'reward_3.jpg',
            'name' => 'Tiket ke Paris',
            'description' => 'Undangan eksklusif untuk mengeksplorasi keanggunan dan romantisme kota cinta ini. Dengan kupon ini, Anda akan merasakan pesona jalan-jalan bersejarah Paris, menikmati panorama menara Eiffel yang megah, dan menjelajahi museum seni dunia seperti Louvre. Paris tidak hanya dikenal sebagai pusat kebudayaan, tetapi juga terkenal dengan kuliner lezatnya, dengan kafe-kafe yang menawarkan pengalaman santai dan hidangan klasik yang memanjakan lidah. Dengan tiket ini, Anda akan diundang untuk merasakan sentuhan kemewahan dan keindahan romantika Paris yang tak tertandingi, menciptakan kenangan indah yang akan dikenang sepanjang hidup. Selamat menikmati petualangan tak terlupakan di kota cahaya yang penuh pesona ini.',
            'points_required' => '450',
        ]);

        Reward::create([
            'image' => 'reward_4.jpg',
            'name' => 'Tiket ke Inggris',
            'description' => 'Peluang eksklusif untuk meresapi sejarah yang kaya, budaya yang beragam, dan keindahan alam yang menawan di daratan Inggris. Dengan kupon ini, Anda akan dapat menjelajahi kota-kota bersejarah seperti London dengan landmark ikoniknya, sementara juga dapat menikmati keindahan pedesaan yang hijau dan pantai yang menakjubkan. Inggris menawarkan pengalaman perjalanan yang menyeluruh, dari istana-istana megah hingga desa-desa yang tradisional, serta kehidupan malam yang dinamis. Selain itu, Anda dapat mengeksplorasi keberagaman kuliner, seni, dan hiburan yang membuat Inggris menjadi destinasi yang unik dan memikat. Dengan tiket ini, nikmati petualangan tak terlupakan di negeri yang penuh dengan pesona dan keajaiban sepanjang perjalanan Anda.',
            'points_required' => '300',
        ]);

        Reward::create([
            'image' => 'reward_5.jpg',
            'name' => 'Tiket ke New York',
            'description' => 'Pintu bagi Anda untuk merasakan getaran kota yang tak pernah tidur, dengan kemewahan dan keberagaman yang menjadi ciri khasnya. Dengan tiket ini, Anda akan terpesona oleh siluet menakjubkan dari gedung pencakar langit ikonik seperti Empire State Building, merasakan kehidupan seni yang berdenyut di Museum Seni Metropolitan, dan mengelilingi taman-taman yang menghijau di Central Park. New York menyajikan pengalaman perbelanjaan mewah di Fifth Avenue, pemandangan Broadway yang memukau, dan kelezatan kuliner dari berbagai belahan dunia. Nikmati sensasi kota yang energetik, penuh dengan keajaiban arsitektur modern, budaya, dan hiburan yang membuat setiap langkah di New York menjadi petualangan tak terlupakan. Selamat menikmati pengalaman luar biasa di jantung kota yang tak pernah berhenti bergerak ini.',
            'points_required' => '350',
        ]);
    }
}
