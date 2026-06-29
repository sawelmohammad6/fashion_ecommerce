<?php

namespace Database\Seeders;

use App\Models\CurrencySetting;
use Illuminate\Database\Seeder;

class CurrencySettingSeeder extends Seeder
{
    public function run(): void
    {
        CurrencySetting::create([
            'currency_name' => 'Bangladeshi Taka',
            'currency_code' => 'BDT',
            'symbol' => '৳',
            'exchange_rate' => 1.0000,
            'is_default' => true,
            'status' => true,
        ]);
    }
}
