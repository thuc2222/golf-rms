<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            ['name' => 'Golf Course Management', 'slug' => 'golf-course', 'description' => 'Core module for managing golf courses', 'version' => '1.0.0', 'is_core' => true, 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Booking System', 'slug' => 'booking', 'description' => 'Core module for managing bookings', 'version' => '1.0.0', 'is_core' => true, 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Tour Management', 'slug' => 'tour', 'description' => 'Core module for managing golf tours', 'version' => '1.0.0', 'is_core' => true, 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Vendor System', 'slug' => 'vendor', 'description' => 'Core module for multivendor functionality', 'version' => '1.0.0', 'is_core' => true, 'is_active' => true, 'sort_order' => 4],
        ];

        foreach ($modules as $module) {
            Module::create($module);
        }
    }
}
