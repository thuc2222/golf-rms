<?php
// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_number', 'user_id', 'golf_course_id', 'tee_time_id',
        'booking_date', 'booking_time', 'players_count', 'subtotal',
        'tax', 'discount', 'total', 'currency', 'status', 'payment_status',
        'payment_method', 'customer_notes', 'admin_notes', 'additional_services',
        'confirmed_at', 'cancelled_at', 'cancellation_reason'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'additional_services' => 'array',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (!$booking->booking_number) {
                $booking->booking_number = 'BK-' . strtoupper(Str::random(10));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function golfCourse()
    {
        return $this->belongsTo(GolfCourse::class);
    }

    public function teeTime()
    {
        return $this->belongsTo(TeeTime::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}