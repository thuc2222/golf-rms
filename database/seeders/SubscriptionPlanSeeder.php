<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Perfect for small golf courses',
                'price' => 49.00,
                'billing_cycle' => 'monthly',
                'course_limit' => 1,
                'booking_limit' => 100,
                'features' => [
                    'Basic Analytics' => 'true',
                    'Email Support' => 'true',
                    'Custom Branding' => 'false',
                    'API Access' => 'false',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Great for growing businesses',
                'price' => 99.00,
                'billing_cycle' => 'monthly',
                'course_limit' => 5,
                'booking_limit' => 500,
                'features' => [
                    'Advanced Analytics' => 'true',
                    'Priority Email Support' => 'true',
                    'Custom Branding' => 'true',
                    'API Access' => 'false',
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large golf course networks',
                'price' => 299.00,
                'billing_cycle' => 'monthly',
                'course_limit' => -1, // unlimited
                'booking_limit' => -1, // unlimited
                'features' => [
                    'Full Analytics Suite' => 'true',
                    '24/7 Phone Support' => 'true',
                    'Custom Branding' => 'true',
                    'API Access' => 'true',
                    'Dedicated Account Manager' => 'true',
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
