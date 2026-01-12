{{-- resources/views/frontend/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - Book Your Perfect Golf Experience')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-green-800 to-green-600 text-white">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                Discover Your Perfect Golf Experience
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-200 max-w-3xl mx-auto">
                Book tee times at world-class golf courses and join unforgettable golf tours
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('courses.index') }}" class="bg-white text-green-800 hover:bg-gray-100 font-bold py-4 px-8 rounded-lg text-lg transition-all transform hover:scale-105">
                    Browse Golf Courses
                </a>
                <a href="{{ route('tours.index') }}" class="bg-green-700 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all transform hover:scale-105 border-2 border-white">
                    Explore Golf Tours
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white dark:bg-gray-800 shadow-lg -mt-12 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['total_courses'] }}+</div>
                <div class="text-gray-600 dark:text-gray-400">Golf Courses</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['total_tours'] }}+</div>
                <div class="text-gray-600 dark:text-gray-400">Golf Tours</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['total_vendors'] }}+</div>
                <div class="text-gray-600 dark:text-gray-400">Trusted Vendors</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Courses -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Golf Courses</h2>
        <a href="{{ route('courses.index') }}" class="text-green-600 hover:text-green-700 font-semibold flex items-center">
            View All
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredCourses as $course)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-1">
                <div class="relative">
                    <img 
                        src="{{ $course->featured_image ? Storage::url($course->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                        alt="{{ $course->name }}"
                        class="w-full h-56 object-cover"
                    >
                    <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Featured
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-green-600 uppercase">{{ $course->course_type }}</span>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ number_format($course->rating, 1) }}</span>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $course->address['city'] ?? 'Location' }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $course->holes_count }} Holes</span>
                    </div>
                    <a href="{{ route('courses.show', $course->slug) }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                        Book Now
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Featured Tours -->
<div class="bg-gray-100 dark:bg-gray-900 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Golf Tours</h2>
            <a href="{{ route('tours.index') }}" class="text-green-600 hover:text-green-700 font-semibold flex items-center">
                View All
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($featuredTours as $tour)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0">
                            <img 
                                src="{{ $tour->featured_image ? Storage::url($tour->featured_image) : 'https://via.placeholder.com/400x300' }}" 
                                alt="{{ $tour->name }}"
                                class="h-48 w-full md:w-48 object-cover"
                            >
                        </div>
                        <div class="p-6 flex-1">
                            <div class="flex items-center mb-2">
                                <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded text-xs font-semibold">
                                    {{ $tour->duration_days }}D/{{ $tour->duration_nights }}N
                                </span>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $tour->rounds_of_golf }} Rounds</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $tour->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ Str::limit($tour->description, 120) }}</p>
                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">${{ number_format($tour->price_from, 0) }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">/person</span>
                                </div>
                                <a href="{{ route('tours.show', $tour->slug) }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                    View Tour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Why Choose Us</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="bg-green-100 dark:bg-green-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Best Prices</h3>
            <p class="text-gray-600 dark:text-gray-400">Competitive rates and exclusive deals on premium golf courses</p>
        </div>
        <div class="text-center">
            <div class="bg-green-100 dark:bg-green-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Instant Booking</h3>
            <p class="text-gray-600 dark:text-gray-400">Real-time availability and instant confirmation</p>
        </div>
        <div class="text-center">
            <div class="bg-green-100 dark:bg-green-900 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">24/7 Support</h3>
            <p class="text-gray-600 dark:text-gray-400">Dedicated customer support whenever you need it</p>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>
@endsection