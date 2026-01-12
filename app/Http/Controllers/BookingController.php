<?php
// app/Http/Controllers/BookingController.php
namespace App\Http\Controllers;

use App\Models\GolfCourse;
use App\Models\TeeTime;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->middleware('auth')->except(['create', 'availability']);
        $this->bookingService = $bookingService;
    }

    public function create(Request $request, $courseSlug)
    {
        $course = GolfCourse::where('slug', $courseSlug)
            ->where('status', 'published')
            ->firstOrFail();

        $selectedDate = $request->get('date', today()->format('Y-m-d'));

        return view('frontend.bookings.create', compact('course', 'selectedDate'));
    }

    public function availability(Request $request, $courseId)
    {
        $date = $request->get('date', today()->format('Y-m-d'));
        
        $teeTimes = $this->bookingService->getAvailableTeeTimes($courseId, $date);

        return response()->json([
            'date' => $date,
            'tee_times' => $teeTimes->map(function ($teeTime) {
                return [
                    'id' => $teeTime->id,
                    'time' => $teeTime->time->format('H:i'),
                    'available_slots' => $teeTime->available_slots - $teeTime->booked_slots,
                    'price' => $teeTime->getCurrentPrice(),
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'golf_course_id' => 'required|exists:golf_courses,id',
            'tee_time_id' => 'required|exists:tee_times,id',
            'players_count' => 'required|integer|min:1|max:4',
            'customer_notes' => 'nullable|string|max:500',
            'additional_services' => 'nullable|array',
        ]);

        try {
            $booking = $this->bookingService->createBooking([
                'user_id' => Auth::id(),
                'golf_course_id' => $validated['golf_course_id'],
                'tee_time_id' => $validated['tee_time_id'],
                'players_count' => $validated['players_count'],
                'customer_notes' => $validated['customer_notes'] ?? null,
                'additional_services' => $validated['additional_services'] ?? null,
                'currency' => session('currency', 'usd'),
            ]);

            return redirect()
                ->route('bookings.payment', $booking->id)
                ->with('success', 'Booking created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['golfCourse', 'teeTime'])
            ->latest()
            ->paginate(10);

        return view('frontend.bookings.my-bookings', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['golfCourse', 'teeTime'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.bookings.show', compact('booking'));
    }

    public function payment($id)
    {
        $booking = Booking::with('golfCourse')
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        return view('frontend.bookings.payment', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        try {
            $this->bookingService->cancelBooking($booking->id, 'Cancelled by customer');

            return redirect()
                ->route('bookings.my-bookings')
                ->with('success', 'Booking cancelled successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}