{{-- resources/views/frontend/courses/holes.blade.php --}}
@extends('layouts.app')

@section('title', $course->name . ' - Course Holes')

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
                <h1 class="text-4xl font-bold">{{ $course->name }}</h1>
                <p class="text-green-100 mt-1">Explore all {{ $course->holes_count }} holes</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Interactive Map -->
    <div class="mb-8">
        @livewire('interactive-course-map', ['courseId' => $course->id])
    </div>

    <!-- Holes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($course->holes as $hole)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                @if($hole->image)
                    <img 
                        src="{{ Storage::url($hole->image) }}" 
                        alt="Hole {{ $hole->hole_number }}"
                        class="w-full h-48 object-cover"
                    >
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                        <span class="text-6xl font-bold text-white opacity-50">{{ $hole->hole_number }}</span>
                    </div>
                @endif

                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Hole {{ $hole->hole_number }}
                        </h3>
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full font-bold">
                            Par {{ $hole->par }}
                        </span>
                    </div>

                    @if($hole->name)
                        <p class="text-gray-600 dark:text-gray-400 font-medium mb-3">{{ $hole->name }}</p>
                    @endif

                    <!-- Yardage -->
                    @if($hole->yardage)
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @if(isset($hole->yardage['championship']))
                                <div class="text-center bg-gray-50 dark:bg-gray-900 p-2 rounded">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Championship</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $hole->yardage['championship'] }}</div>
                                </div>
                            @endif
                            @if(isset($hole->yardage['regular']))
                                <div class="text-center bg-gray-50 dark:bg-gray-900 p-2 rounded">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Regular</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $hole->yardage['regular'] }}</div>
                                </div>
                            @endif
                            @if(isset($hole->yardage['forward']))
                                <div class="text-center bg-gray-50 dark:bg-gray-900 p-2 rounded">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Forward</div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $hole->yardage['forward'] }}</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Description -->
                    @if($hole->description)
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ $hole->description }}</p>
                    @endif

                    <!-- Hazards -->
                    @if($hole->hazards && count($hole->hazards) > 0)
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($hole->hazards as $hazard)
                                <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded text-xs font-semibold">
                                    {{ ucwords(str_replace('_', ' ', $hazard)) }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Tips -->
                    @if($hole->tips)
                        <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-500 p-3 rounded">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-blue-800 dark:text-blue-200">{{ $hole->tips }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection