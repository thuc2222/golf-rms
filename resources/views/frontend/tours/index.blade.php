{{-- resources/views/frontend/tours/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Golf Tours')

@section('content')
<div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Discover Golf Tours</h1>
        <p class="text-blue-100">Experience unforgettable golf adventures around the world</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('tour-filter')
</div>
@endsection