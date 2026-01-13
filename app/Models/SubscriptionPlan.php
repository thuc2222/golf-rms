<?php

// app/Models/SubscriptionPlan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class SubscriptionPlan extends Model
{
    use Translatable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'billing_cycle',
        'course_limit',
        'booking_limit',
        'features',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $translatable = ['name', 'description'];

    public function vendorSubscriptions()
    {
        return $this->hasMany(VendorSubscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}