<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" type="button" 
            class="flex items-center text-gray-700 hover:text-primary-600">
        <span class="mr-2">{{ $currencies[$currentCurrency]['symbol'] ?? '$' }}</span>
        <span class="hidden sm:inline">{{ $currentCurrency }}</span>
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1">
            @foreach($currencies as $code => $currency)
                <button wire:click="switchCurrency('{{ $code }}')" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center
                               {{ $currentCurrency === $code ? 'bg-gray-100' : '' }}">
                    <span class="mr-2">{{ $currency['symbol'] }}</span>
                    <span>{{ $currency['name'] }} ({{ $code }})</span>
                    @if($currentCurrency === $code)
                        <svg class="w-4 h-4 ml-auto text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>