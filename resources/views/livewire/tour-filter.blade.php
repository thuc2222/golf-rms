{{-- resources/views/livewire/tour-filter.blade.php --}}
<div class="space-y-6">
    {{-- Search & Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Search Tours
                </label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by name..."
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            {{-- Difficulty --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Difficulty
                </label>
                <select 
                    wire:model.live="difficulty"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">All Levels</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                    <option value="all_levels">All Levels</option>
                </select>
            </div>

            {{-- Duration --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Duration
                </label>
                <select 
                    wire:model.live="durationRange"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Any Duration</option>
                    <option value="1-3">1-3 Days</option>
                    <option value="4-7">4-7 Days</option>
                    <option value="8+">8+ Days</option>
                </select>
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Sort By
                </label>
                <select 
                    wire:model.live="sortBy"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="name">Name</option>
                    <option value="price">Price (Low to High)</option>
                    <option value="rating">Rating</option>
                    <option value="duration">Duration</option>
                </select>
            </div>
        </div>

        {{-- Price Range --}}
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Price Range
            </label>
            <div class="flex gap-4">
                <input 
                    type="number" 
                    wire:model.live="minPrice"
                    placeholder="Min price"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                <input 
                    type="number" 
                    wire:model.live="maxPrice"
                    placeholder="Max price"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-4 flex justify-between">
            <button 
                wire:click="clearFilters"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600"
            >
                Clear Filters
            </button>
        </div>
    </div>

    {{-- Results --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tours as $tour)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:-translate-y-1">
                <img 
                    src="{{ $tour->featured_image ? Storage::url($tour->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                    alt="{{ $tour->name }}"
                    class="w-full h-48 object-cover"
                >
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">
                            {{ $tour->duration_days }}D/{{ $tour->duration_nights }}N
                        </span>
                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded text-xs font-semibold">
                            {{ $tour->rounds_of_golf }} Rounds
                        </span>
                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded text-xs font-semibold">
                            {{ ucfirst($tour->difficulty_level) }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $tour->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($tour->description, 100) }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($tour->price_from, 0) }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">/person</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ number_format($tour->rating, 1) }}</span>
                        </div>
                    </div>
                    <a 
                        href="{{ route('tours.show', $tour->slug) }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors"
                    >
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">No tours found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $tours->links() }}
    </div>
</div>