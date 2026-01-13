<?php
// app/Models/VendorSubscription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorSubscription extends Model
{
    protected $fillable = [
        'vendor_id',
        'subscription_plan_id',
        'started_at',
        'expires_at',
        'status',
        'cancelled_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at->isFuture();
    }

    public function isExpired()
    {
        return $this->status === 'expired' || $this->expires_at->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('expires_at', '>', now());
    }
}