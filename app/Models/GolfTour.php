<?php
// app/Models/GolfTour.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class GolfTour extends Model
{
    use SoftDeletes, Translatable;

    protected $fillable = [
        'vendor_id', 'name', 'slug', 'description', 'itinerary',
        'featured_image', 'gallery', 'duration_days', 'duration_nights',
        'rounds_of_golf', 'price_from', 'min_participants', 'max_participants',
        'included_courses', 'inclusions', 'exclusions', 'difficulty_level',
        'status', 'is_featured', 'rating', 'reviews_count',
        'available_from', 'available_to'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price_from' => 'decimal:2',
        'included_courses' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2',
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    protected $translatable = ['name', 'description', 'itinerary'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
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