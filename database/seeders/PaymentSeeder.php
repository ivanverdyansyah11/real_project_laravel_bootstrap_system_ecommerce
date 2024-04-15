<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'bank_name' => 'Cash',
            'owner_name' => '',
            'account_number' => '',
        ]);

        Payment::create([
            'bank_name' => 'Bank Mandiri',
            'owner_name' => 'PT ADIGOEROE SIWA AMBARA',
            'account_number' => '145-00-1560890-0',
        ]);

        Payment::create([
            'bank_name' => 'Bank BCA',
            'owner_name' => 'ADIGOEROE SIWA AMBARA PT',
            'account_number' => '435-8003000',
        ]);

        Payment::create([
            'bank_name' => 'Bank BRI',
            'owner_name' => 'ADIGOEROE SIWA AMBARA',
            'account_number' => '0572-01-001545-56-1',
        ]);

        Payment::create([
            'bank_name' => 'Bank BNI',
            'owner_name' => 'PT ADIGOEROE SIWA AMBARA',
            'account_number' => '1793792801',
        ]);
    }
}
