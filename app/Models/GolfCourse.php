<?php
// app/Models/GolfCourse.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class GolfCourse extends Model
{
    use SoftDeletes, Translatable;

    protected $fillable = [
        'vendor_id', 'name', 'slug', 'description', 'featured_image',
        'gallery', 'address', 'latitude', 'longitude', 'phone', 'email',
        'website', 'holes_count', 'par', 'course_type', 'facilities',
        'amenities', 'rating', 'reviews_count', 'status', 'is_featured',
        'operating_hours'
    ];

    protected $casts = [
        'gallery' => 'array',
        'address' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'facilities' => 'array',
        'amenities' => 'array',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'operating_hours' => 'array',
    ];

    protected $translatable = ['name', 'description'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function holes()
    {
        return $this->hasMany(GolfHole::class)->orderBy('hole_number');
    }

    public function teeTimes()
    {
        return $this->hasMany(TeeTime::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}