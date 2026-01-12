{{-- resources/views/filament/resources/language-resource/pages/list-languages.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Quick Actions --}}
        <div class="flex gap-4 mb-6">
            <x-filament::button 
                wire:click="$dispatch('openModal', { component: 'create-language-modal' })"
                icon="heroicon-o-plus"
            >
                Add Language
            </x-filament::button>
        </div>

        {{-- Languages Table --}}
        <div class="overflow-x-auto">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>