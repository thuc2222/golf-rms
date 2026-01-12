@extends('layouts.app')

@section('title', 'Golf Vendors')

@section('content')
<div class="bg-gradient-to-r from-purple-700 to-purple-500 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Trusted Golf Vendors</h1>
        <p class="text-purple-100">Discover top-rated golf course operators and tour organizers</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('vendors.index') }}" class="flex gap-4">
            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Search vendors..."
                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-purple-500 focus:ring-purple-500"
            >
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-8 py-2 rounded-md transition-colors">
                Search
            </button>
        </form>
    </div>

    <!-- Vendors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($vendors as $vendor)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                <!-- Banner -->
                @if($vendor->banner)
                    <img 
                        src="{{ Storage::url($vendor->banner) }}" 
                        alt="{{ $vendor->business_name }}"
                        class="w-full h-48 object-cover"
                    >
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-purple-400 to-purple-600"></div>
                @endif

                <div class="p-6">
                    <!-- Logo & Name -->
                    <div class="flex items-center mb-4">
                        @if($vendor->logo)
                            <img 
                                src="{{ Storage::url($vendor->logo) }}" 
                                alt="{{ $vendor->business_name }}"
                                class="w-16 h-16 rounded-full border-4 border-white dark:border-gray-800 shadow-lg -mt-12 mr-4"
                            >
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->business_name }}</h3>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Verified
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                        {{ $vendor->description }}
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $vendor->golfCourses->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Courses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $vendor->golfTours->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Tours</div>
                        </div>
                    </div>

                    <!-- View Button -->
                    <a href="{{ route('vendors.show', $vendor->slug) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                        View Profile
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">No vendors found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $vendors->links() }}
    </div>
</div>
@endsection