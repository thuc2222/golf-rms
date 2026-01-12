{{-- resources/views/frontend/tours/show.blade.php --}}
@extends('layouts.app')

@section('title', $tour->name)

@section('content')
<!-- Tour Header -->
<div class="relative h-96 bg-gray-900">
    <img 
        src="{{ $tour->featured_image ? Storage::url($tour->featured_image) : 'https://via.placeholder.com/1920x600' }}" 
        alt="{{ $tour->name }}"
        class="w-full h-full object-cover opacity-75"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center space-x-2 mb-2">
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $tour->duration_days }}D/{{ $tour->duration_nights }}N
                </span>
                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $tour->rounds_of_golf }} Rounds
                </span>
                @if($tour->is_featured)
                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Featured</span>
                @endif
            </div>
            <h1 class="text-5xl font-bold text-white mb-2">{{ $tour->name }}</h1>
            <div class="flex items-center text-white text-lg">
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded">{{ ucfirst($tour->difficulty_level) }}</span>
                <span class="mx-3">•</span>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-semibold">{{ number_format($tour->rating, 1) }}</span>
                    <span class="text-gray-300 ml-1">({{ $tour->reviews_count }} reviews)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Overview -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $tour->duration_days }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Days</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $tour->duration_nights }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Nights</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $tour->rounds_of_golf }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Rounds</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $tour->min_participants }}-{{ $tour->max_participants }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Group Size</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tour Overview</h2>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {{ $tour->description }}
                </div>
            </div>

            <!-- Detailed Itinerary -->
            @if($tour->itinerary)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Detailed Itinerary</h2>
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        {!! nl2br(e($tour->itinerary)) !!}
                    </div>
                </div>
            @endif

            <!-- Inclusions -->
            @if($tour->inclusions && count($tour->inclusions) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What's Included</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($tour->inclusions as $inclusion)
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $inclusion }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Exclusions -->
            @if($tour->exclusions && count($tour->exclusions) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What's Not Included</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($tour->exclusions as $exclusion)
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $exclusion }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Gallery -->
            @if($tour->gallery && count($tour->gallery) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tour Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($tour->gallery as $image)
                            <img 
                                src="{{ Storage::url($image) }}" 
                                alt="Tour gallery"
                                class="rounded-lg h-48 w-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                            >
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Important Information -->
            <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-500 rounded-lg p-6">
                <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-3 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Important Information
                </h3>
                <ul class="text-yellow-800 dark:text-yellow-200 space-y-2 text-sm">
                    <li>• Minimum {{ $tour->min_participants }} participants required for tour to proceed</li>
                    <li>• Difficulty level: {{ ucfirst($tour->difficulty_level) }}</li>
                    <li>• Cancellation policy: Free cancellation up to 14 days before departure</li>
                    <li>• Valid passport required for international tours</li>
                    @if($tour->available_from && $tour->available_to)
                        <li>• Available from {{ $tour->available_from->format('F d, Y') }} to {{ $tour->available_to->format('F d, Y') }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-20">
                <!-- Pricing -->
                <div class="mb-6">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Starting from</div>
                    <div class="text-4xl font-bold text-blue-600 mb-1">${{ number_format($tour->price_from, 0) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">per person</div>
                </div>

                <!-- Book Button -->
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg text-lg transition-colors mb-4">
                    Request Booking
                </button>

                <div class="text-center text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Or call us at (123) 456-7890
                </div>

                <!-- Tour Details -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Duration</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $tour->duration_days }}D/{{ $tour->duration_nights }}N</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Golf Rounds</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $tour->rounds_of_golf }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Difficulty</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($tour->difficulty_level) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Group Size</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $tour->min_participants }}-{{ $tour->max_participants }}</span>
                    </div>
                </div>

                <!-- Vendor Info -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Tour Operator</h4>
                    <div class="flex items-center">
                        @if($tour->vendor->logo)
                            <img src="{{ Storage::url($tour->vendor->logo) }}" alt="{{ $tour->vendor->business_name }}" class="w-12 h-12 rounded-full mr-3">
                        @endif
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $tour->vendor->business_name }}</div>
                            <a href="{{ route('vendors.show', $tour->vendor->slug) }}" class="text-sm text-blue-600 hover:text-blue-700">
                                View Profile →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Why Book With Us -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Why Book With Us</h4>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Best price guarantee
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Free cancellation
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            24/7 customer support
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Secure payment
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Related Tours -->
            @if($relatedTours->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Similar Tours</h3>
                    <div class="space-y-4">
                        @foreach($relatedTours as $related)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                <a href="{{ route('tours.show', $related->slug) }}">
                                    @if($related->featured_image)
                                        <img 
                                            src="{{ Storage::url($related->featured_image) }}" 
                                            alt="{{ $related->name }}"
                                            class="w-full h-32 object-cover rounded-lg mb-3"
                                        >
                                    @endif
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-2 hover:text-blue-600">{{ $related->name }}</h4>
                                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                                        <span>{{ $related->duration_days }}D/{{ $related->duration_nights }}N</span>
                                        <span class="font-bold text-blue-600">${{ number_format($related->price_from, 0) }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection