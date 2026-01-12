{{-- resources/views/livewire/currency-switcher.blade.php --}}
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 px-3 py-2">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm">{{ strtoupper($currentCurrency) }}</span>
    </button>

    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
        @foreach($currencies as $currency)
            <button
                wire:click="switchCurrency('{{ $currency->code }}')"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ $currentCurrency === strtolower($currency->code) ? 'bg-primary-50 dark:bg-primary-900' : '' }}"
            >
                <span class="font-medium">{{ $currency->symbol }}</span>
                {{ $currency->name }} ({{ $currency->code }})
            </button>
        @endforeach
    </div>
</div>