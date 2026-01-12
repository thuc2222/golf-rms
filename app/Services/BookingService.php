<?php
// app/Services/BookingService.php
namespace App\Services;

use App\Models\Booking;
use App\Models\TeeTime;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking($data)
    {
        return DB::transaction(function () use ($data) {
            $teeTime = TeeTime::findOrFail($data['tee_time_id']);

            // Check availability
            if (!$teeTime->hasAvailableSlots()) {
                throw new \Exception('No available slots for this tee time');
            }

            // Calculate pricing
            $subtotal = $teeTime->getCurrentPrice() * $data['players_count'];
            $tax = $subtotal * 0.1; // 10% tax (configurable)
            $discount = $data['discount'] ?? 0;
            $total = $subtotal + $tax - $discount;

            // Create booking
            $booking = Booking::create([
                'user_id' => $data['user_id'],
                'golf_course_id' => $teeTime->golf_course_id,
                'tee_time_id' => $teeTime->id,
                'booking_date' => $teeTime->date,
                'booking_time' => $teeTime->time,
                'players_count' => $data['players_count'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'currency' => $data['currency'] ?? 'usd',
                'customer_notes' => $data['customer_notes'] ?? null,
                'additional_services' => $data['additional_services'] ?? null,
            ]);

            // Update tee time
            $teeTime->increment('booked_slots', $data['players_count']);

            return $booking;
        });
    }

    public function confirmBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Send confirmation email/notification

        return $booking;
    }

    public function cancelBooking($bookingId, $reason = null)
    {
        return DB::transaction(function () use ($bookingId, $reason) {
            $booking = Booking::findOrFail($bookingId);

            if ($booking->status === 'cancelled') {
                throw new \Exception('Booking already cancelled');
            }

            // Free up tee time slots
            if ($booking->tee_time_id) {
                $booking->teeTime->decrement('booked_slots', $booking->players_count);
            }

            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ]);

            // Process refund if applicable

            return $booking;
        });
    }

    public function getAvailableTeeTimes($courseId, $date)
    {
        return TeeTime::where('golf_course_id', $courseId)
            ->where('date', $date)
            ->where('is_available', true)
            ->whereRaw('available_slots > booked_slots')
            ->orderBy('time')
            ->get();
    }
}