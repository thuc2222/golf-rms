<?php
// app/Models/TeeTime.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeeTime extends Model
{
    protected $fillable = [
        'golf_course_id', 'date', 'time', 'available_slots',
        'booked_slots', 'price', 'weekend_price', 'pricing_rules',
        'is_available', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'weekend_price' => 'decimal:2',
        'pricing_rules' => 'array',
        'is_available' => 'boolean',
    ];

    public function golfCourse()
    {
        return $this->belongsTo(GolfCourse::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function hasAvailableSlots()
    {
        return $this->available_slots > $this->booked_slots;
    }

    public function getCurrentPrice()
    {
        $isWeekend = in_array($this->date->dayOfWeek, [0, 6]); // Sunday = 0, Saturday = 6
        return $isWeekend && $this->weekend_price ? $this->weekend_price : $this->price;
    }
}