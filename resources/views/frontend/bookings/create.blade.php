{{-- resources/views/frontend/bookings/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Book Tee Time - ' . $course->name)

@section('content')
<div class="bg-gradient-to-r from-green-700 to-green-500 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('courses.show', $course->slug) }}" class="text-white hover:text-green-100 mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-bold">Book Your Tee Time</h1>
                <p class="text-green-100 mt-1">{{ $course->name }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Form -->
        <div class="lg:col-span-2">
            @livewire('booking-form', ['courseId' => $course->id])
        </div>

        <!-- Course Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden sticky top-20">
                @if($course->featured_image)
                    <img 
                        src="{{ Storage::url($course->featured_image) }}" 
                        alt="{{ $course->name }}"
                        class="w-full h-48 object-cover"
                    >
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $course->name }}</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            {{ $course->address['city'] ?? 'Location' }}
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            {{ $course->holes_count }} Holes
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Par {{ $course->par }}
                        </div>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">Booking Information</h4>
                        <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                            <li>• Instant confirmation</li>
                            <li>• Free cancellation up to 48 hours</li>
                            <li>• Secure payment</li>
                            <li>• Email & SMS reminders</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection