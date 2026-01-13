{{-- resources/views/components/golf-hole-selector.blade.php --}}
<div 
    x-data="{
        selectedHole: null,
        holes: @js($holes ?? []),
        imageUrl: @js($imageUrl ?? ''),
        showHoleInfo: false
    }"
    class="relative"
>
    {{-- Course Image with Interactive Holes --}}
    <div class="relative w-full">
        <img 
            :src="imageUrl" 
            alt="Golf Course Map"
            class="w-full h-auto rounded-lg shadow-lg"
        >
        
        {{-- Hole Markers --}}
        <template x-for="hole in holes" :key="hole.id">
            <button
                @click="selectedHole = hole; showHoleInfo = true"
                :style="`left: ${hole.coordinates.x}%; top: ${hole.coordinates.y}%;`"
                class="absolute transform -translate-x-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-primary-600 hover:bg-primary-700 text-white font-semibold shadow-lg transition-all hover:scale-110 flex items-center justify-center"
                :class="{ 'ring-4 ring-primary-400': selectedHole?.id === hole.id }"
            >
                <span x-text="hole.hole_number"></span>
            </button>
        </template>
    </div>

    {{-- Hole Information Panel --}}
    <div 
        x-show="showHoleInfo && selectedHole"
        x-transition
        class="mt-6 bg-white rounded-lg shadow-lg p-6"
    >
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-2xl font-bold" x-text="`Hole ${selectedHole?.hole_number}`"></h3>
                <p class="text-gray-600" x-text="selectedHole?.name"></p>
            </div>
            <button 
                @click="showHoleInfo = false"
                class="text-gray-400 hover:text-gray-600"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div>
                <p class="text-sm text-gray-500">Par</p>
                <p class="text-xl font-bold" x-text="selectedHole?.par"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Championship</p>
                <p class="text-xl font-bold" x-text="`${selectedHole?.yardage?.championship} yds`"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Regular</p>
                <p class="text-xl font-bold" x-text="`${selectedHole?.yardage?.regular} yds`"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Handicap</p>
                <p class="text-xl font-bold" x-text="selectedHole?.handicap"></p>
            </div>
        </div>

        <div x-show="selectedHole?.description" class="mb-4">
            <h4 class="font-semibold mb-2">Description</h4>
            <p class="text-gray-600" x-text="selectedHole?.description"></p>
        </div>

        <div x-show="selectedHole?.hazards?.length > 0" class="mb-4">
            <h4 class="font-semibold mb-2">Hazards</h4>
            <div class="flex flex-wrap gap-2">
                <template x-for="hazard in selectedHole?.hazards" :key="hazard">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <span x-text="hazard.replace('_', ' ')"></span>
                    </span>
                </template>
            </div>
        </div>

        <div x-show="selectedHole?.tips">
            <h4 class="font-semibold mb-2">Playing Tips</h4>
            <p class="text-gray-600" x-text="selectedHole?.tips"></p>
        </div>

        <div x-show="selectedHole?.image" class="mt-4">
            <img 
                :src="selectedHole?.image" 
                :alt="`Hole ${selectedHole?.hole_number}`"
                class="w-full h-64 object-cover rounded-lg"
            >
        </div>
    </div>
</div>