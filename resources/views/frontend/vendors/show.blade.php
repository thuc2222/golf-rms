{{-- resources/views/frontend/vendors/show.blade.php --}}
@extends('layouts.app')

@section('title', $vendor->business_name)

@section('content')
<!-- Vendor Header -->
<div class="relative h-80 bg-gray-900">
    @if($vendor->banner)
        <img 
            src="{{ Storage::url($vendor->banner) }}" 
            alt="{{ $vendor->business_name }}"
            class="w-full h-full object-cover opacity-75"
        >
    @else
        <div class="w-full h-full bg-gradient-to-r from-purple-700 to-purple-500"></div>
    @endif
    
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end">
                @if($vendor->logo)
                    <img 
                        src="{{ Storage::url($vendor->logo) }}" 
                        alt="{{ $vendor->business_name }}"
                        class="w-32 h-32 rounded-lg border-4 border-white shadow-xl mr-6"
                    >
                @endif
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Verified Vendor
                        </span>
                    </div>
                    <h1 class="text-5xl font-bold text-white mb-2">{{ $vendor->business_name }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- About -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About Us</h2>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {{ $vendor->description }}
                </div>
            </div>

            <!-- Golf Courses -->
            @if($vendor->golfCourses->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Our Golf Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($vendor->golfCourses as $course)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                @if($course->featured_image)
                                    <img 
                                        src="{{ Storage::url($course->featured_image) }}" 
                                        alt="{{ $course->name }}"
                                        class="w-full h-40 object-cover"
                                    >
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $course->name }}</h3>
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        <span>{{ $course->holes_count }} Holes</span>
                                        <span class="mx-2">•</span>
                                        <span>Par {{ $course->par }}</span>
                                        <span class="mx-2">•</span>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ number_format($course->rating, 1) }}
                                        </div>
                                    </div>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm">
                                        View Course
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Golf Tours -->
            @if($vendor->golfTours->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Our Golf Tours</h2>
                    <div class="space-y-4">
                        @foreach($vendor->golfTours as $tour)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="md:flex">
                                    <div class="md:flex-shrink-0">
                                        @if($tour->featured_image)
                                            <img 
                                                src="{{ Storage::url($tour->featured_image) }}" 
                                                alt="{{ $tour->name }}"
                                                class="h-full w-full md:w-48 object-cover"
                                            >
                                        @endif
                                    </div>
                                    <div class="p-4 flex-1">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">
                                                {{ $tour->duration_days }}D/{{ $tour->duration_nights }}N
                                            </span>
                                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $tour->rounds_of_golf }} Rounds</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $tour->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ Str::limit($tour->description, 120) }}</p>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="text-2xl font-bold text-blue-600">${{ number_format($tour->price_from, 0) }}</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">/person</span>
                                            </div>
                                            <a href="{{ route('tours.show', $tour->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors text-sm">
                                                View Tour
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-20">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                
                <div class="space-y-4 mb-6">
                    @if($vendor->email)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $vendor->email }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600">
                                {{ $vendor->email }}
                            </a>
                        </div>
                    @endif

                    @if($vendor->phone)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $vendor->phone }}" class="text-gray-700 dark:text-gray-300 hover:text-purple-600">
                                {{ $vendor->phone }}
                            </a>
                        </div>
                    @endif

                    @if($vendor->website)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="{{ $vendor->website }}" target="_blank" rel="noopener noreferrer" class="text-gray-700 dark:text-gray-300 hover:text-purple-600">
                                Visit Website
                            </a>
                        </div>
                    @endif

                    @if($vendor->address)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div class="text-gray-700 dark:text-gray-300">
                                @if(isset($vendor->address['street']))
                                    {{ $vendor->address['street'] }}<br>
                                @endif
                                @if(isset($vendor->address['city']))
                                    {{ $vendor->address['city'] }}
                                @endif
                                @if(isset($vendor->address['state']))
                                    , {{ $vendor->address['state'] }}
                                @endif
                                @if(isset($vendor->address['zip']))
                                    {{ $vendor->address['zip'] }}
                                @endif
                                @if(isset($vendor->address['country']))
                                    <br>{{ $vendor->address['country'] }}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    Contact Vendor
                </button>

                <!-- Stats -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                            <div class="text-3xl font-bold text-purple-600">{{ $vendor->golfCourses->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Courses</div>
                        </div>
                        <div class="text-center bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                            <div class="text-3xl font-bold text-purple-600">{{ $vendor->golfTours->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tours</div>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Trust & Safety</h4>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Verified Business
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Secure Payments
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            24/7 Support
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection