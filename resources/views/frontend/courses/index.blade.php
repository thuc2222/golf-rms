{{-- resources/views/frontend/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Golf Courses')

@section('content')
<div class="bg-gradient-to-r from-green-700 to-green-500 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Discover Golf Courses</h1>
        <p class="text-green-100">Find and book tee times at world-class golf courses</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('course-search')
</div>
@endsection