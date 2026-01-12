{{-- resources/views/components/currency-selector.blade.php --}}
<div 
    x-data="{
        currencies: @js($currencies ?? []),
        selected: @js($selected ?? 'usd'),
        open: false
    }"
    class="relative"
>
    <button 
        @click="open = !open"
        type="button"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
    >
        <span x-text="currencies.find(c => c.code === selected)?.symbol"></span>
        <span x-text="selected.toUpperCase()"></span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div 
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            <template x-for="currency in currencies" :key="currency.code">
                <button
                    @click="selected = currency.code; open = false; $dispatch('currency-changed', { currency: currency.code })"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-between"
                    :class="{ 'bg-primary-50 dark:bg-primary-900': selected === currency.code }"
                >
                    <span class="flex items-center gap-2">
                        <span x-text="currency.symbol"></span>
                        <span x-text="currency.name"></span>
                    </span>
                    <span x-text="currency.code.toUpperCase()" class="text-xs text-gray-500"></span>
                </button>
            </template>
        </div>
    </div>
</div>