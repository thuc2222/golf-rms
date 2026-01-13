{{-- resources/views/components/language-selector.blade.php --}}
<div 
    x-data="{
        languages: @js($languages ?? []),
        selected: @js($selected ?? 'en'),
        open: false
    }"
    class="relative"
>
    <button 
        @click="open = !open"
        type="button"
        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
        <span x-text="languages.find(l => l.code === selected)?.native_name"></span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div 
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            <template x-for="language in languages" :key="language.code">
                <button
                    @click="selected = language.code; open = false; $dispatch('language-changed', { language: language.code })"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-between"
                    :class="{ 'bg-primary-50': selected === language.code }"
                >
                    <span x-text="language.native_name"></span>
                    <span x-text="language.code.toUpperCase()" class="text-xs text-gray-500"></span>
                </button>
            </template>
        </div>
    </div>
</div>