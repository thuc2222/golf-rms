<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1.0000, 'is_default' => true, 'is_active' => true, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.9200, 'is_default' => false, 'is_active' => true, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'exchange_rate' => 0.7900, 'is_default' => false, 'is_active' => true, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'exchange_rate' => 149.5000, 'is_default' => false, 'is_active' => true, 'format' => '{symbol}{amount}', 'decimal_places' => 0],
            ['code' => 'VND', 'name' => 'Vietnamese Dong', 'symbol' => '₫', 'exchange_rate' => 24500.0000, 'is_default' => false, 'is_active' => true, 'format' => '{amount}{symbol}', 'decimal_places' => 0],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
