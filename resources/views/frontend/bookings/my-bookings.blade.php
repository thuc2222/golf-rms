{{-- resources/views/frontend/bookings/my-bookings.blade.php --}}
@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="bg-gradient-to-r from-green-700 to-green-500 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold">My Bookings</h1>
        <p class="text-green-100 mt-1">View and manage your golf course reservations</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($bookings->count() > 0)
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0">
                            <img 
                                src="{{ $booking->golfCourse->featured_image ? Storage::url($booking->golfCourse->featured_image) : 'https://via.placeholder.com/300x200' }}" 
                                alt="{{ $booking->golfCourse->name }}"
                                class="h-full w-full md:w-64 object-cover"
                            >
                        </div>
                        <div class="p-6 flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        Booking #{{ $booking->booking_number }}
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $booking->golfCourse->name }}
                                    </h3>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $booking->booking_date->format('F d, Y') }} at {{ $booking->booking_time->format('g:i A') }}
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Players</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $booking->players_count }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Total</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($booking->total, 2) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Payment</div>
                                    <div class="text-lg font-semibold
                                        @if($booking->payment_status === 'paid') text-green-600
                                        @elseif($booking->payment_status === 'pending') text-yellow-600
                                        @else text-red-600
                                        @endif">
                                        {{ ucfirst($booking->payment_status) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Booked</div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->created_at->diffForHumans() }}</div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    View Details
                                </a>
                                @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Bookings Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Start exploring our golf courses and book your first tee time!</p>
            <a href="{{ route('courses.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                Browse Golf Courses
            </a>
        </div>
    @endif
</div>
@endsection