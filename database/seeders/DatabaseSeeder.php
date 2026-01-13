<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            ModuleSeeder::class,
            SubscriptionPlanSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
