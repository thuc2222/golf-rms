<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_rtl' => false, 'is_default' => true, 'is_active' => true, 'sort_order' => 0],
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_rtl' => false, 'is_default' => false, 'is_active' => true, 'sort_order' => 1],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_rtl' => false, 'is_default' => false, 'is_active' => true, 'sort_order' => 2],
            ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch', 'is_rtl' => false, 'is_default' => false, 'is_active' => true, 'sort_order' => 3],
            ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية', 'is_rtl' => true, 'is_default' => false, 'is_active' => true, 'sort_order' => 4],
            ['code' => 'zh', 'name' => 'Chinese', 'native_name' => '中文', 'is_rtl' => false, 'is_default' => false, 'is_active' => true, 'sort_order' => 5],
            ['code' => 'vi', 'name' => 'Vietnamese', 'native_name' => 'Tiếng Việt', 'is_rtl' => false, 'is_default' => false, 'is_active' => true, 'sort_order' => 6],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
