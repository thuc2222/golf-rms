<?php
// app/Models/Vendor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Vendor extends Model
{
    use Translatable;

    protected $fillable = [
        'user_id', 'business_name', 'slug', 'description',
        'logo', 'banner', 'phone', 'email', 'website',
        'address', 'status', 'commission_rate', 'business_documents',
        'verified_at'
    ];

    protected $casts = [
        'address' => 'array',
        'business_documents' => 'array',
        'commission_rate' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    protected $translatable = ['description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function golfCourses()
    {
        return $this->hasMany(GolfCourse::class);
    }

    public function golfTours()
    {
        return $this->hasMany(GolfTour::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(VendorSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(VendorSubscription::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}