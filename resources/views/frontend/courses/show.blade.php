{{-- resources/views/frontend/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', $course->name)

@section('content')
<!-- Course Header -->
<div class="relative h-96 bg-gray-900">
    <img 
        src="{{ $course->featured_image ? Storage::url($course->featured_image) : 'https://via.placeholder.com/1920x600' }}" 
        alt="{{ $course->name }}"
        class="w-full h-full object-cover opacity-75"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-2 mb-2">
                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ ucwords($course->course_type) }}
                </span>
                @if($course->is_featured)
                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Featured</span>
                @endif
            </div>
            <h1 class="text-5xl font-bold text-white mb-2">{{ $course->name }}</h1>
            <div class="flex items-center text-white text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                </svg>
                <span>{{ $course->address['city'] ?? 'Location' }}, {{ $course->address['country'] ?? '' }}</span>
                <span class="mx-3">•</span>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-semibold">{{ number_format($course->rating, 1) }}</span>
                    <span class="text-gray-300 ml-1">({{ $course->reviews_count }} reviews)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $course->holes_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Holes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $course->par }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Par</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($course->rating, 1) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Rating</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ ucwords($course->course_type) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Type</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About This Course</h2>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {{ $course->description }}
                </div>
            </div>

            <!-- Facilities & Amenities -->
            @if($course->facilities || $course->amenities)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Facilities & Amenities</h2>
                    
                    @if($course->facilities)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Facilities</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($course->facilities as $facility)
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ ucwords(str_replace('_', ' ', $facility)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($course->amenities)
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Amenities</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($course->amenities as $amenity)
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ ucwords(str_replace('_', ' ', $amenity)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Interactive Hole Map -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Course Map</h2>
                    <a href="{{ route('courses.holes', $course->slug) }}" class="text-green-600 hover:text-green-700 font-semibold">
                        View All Holes
                    </a>
                </div>
                @livewire('interactive-course-map', ['courseId' => $course->id])
            </div>

            <!-- Gallery -->
            @if($course->gallery && count($course->gallery) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($course->gallery as $image)
                            <img 
                                src="{{ Storage::url($image) }}" 
                                alt="Course gallery"
                                class="rounded-lg h-48 w-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                            >
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-20">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Book a Tee Time</h3>
                
                <a href="{{ route('bookings.create', $course->slug) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg text-center text-lg transition-colors mb-4">
                    Book Now
                </a>

                <!-- Vendor Info -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Managed By</h4>
                    <div class="flex items-center">
                        @if($course->vendor->logo)
                            <img src="{{ Storage::url($course->vendor->logo) }}" alt="{{ $course->vendor->business_name }}" class="w-12 h-12 rounded-full mr-3">
                        @endif
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $course->vendor->business_name }}</div>
                            <a href="{{ route('vendors.show', $course->vendor->slug) }}" class="text-sm text-green-600 hover:text-green-700">
                                View Profile →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                @if($course->phone || $course->email)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Contact</h4>
                        @if($course->phone)
                            <div class="flex items-center text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $course->phone }}
                            </div>
                        @endif
                        @if($course->email)
                            <div class="flex items-center text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $course->email }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Similar Courses -->
            @if($similarCourses->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Similar Courses</h3>
                    <div class="space-y-4">
                        @foreach($similarCourses as $similar)
                            <div class="flex space-x-3">
                                <img 
                                    src="{{ $similar->featured_image ? Storage::url($similar->featured_image) : 'https://via.placeholder.com/100' }}" 
                                    alt="{{ $similar->name }}"
                                    class="w-20 h-20 object-cover rounded-lg"
                                >
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $similar->name }}</h4>
                                    <div class="flex items-center text-xs text-gray-600 dark:text-gray-400 mb-2">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($similar->rating, 1) }}
                                    </div>
                                    <a href="{{ route('courses.show', $similar->slug) }}" class="text-green-600 hover:text-green-700 text-xs font-semibold">
                                        View Course →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection