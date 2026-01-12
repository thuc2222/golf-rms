{{-- resources/views/filament/pages/settings.blade.php --}}
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>

{{-- resources/views/filament/pages/module-manager.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Installed Modules --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Installed Modules</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($modules as $module)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $module['name'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Version {{ $module['version'] }}
                                </p>
                            </div>
                            
                            @if($module['is_core'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Core
                                </span>
                            @else
                                <button 
                                    wire:click="toggleModule({{ $module['id'] }})"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $module['is_active'] ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700' }}"
                                >
                                    <span class="sr-only">Toggle module</span>
                                    <span class="{{ $module['is_active'] ? 'translate-x-6' : 'translate-x-1' }} inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                                </button>
                            @endif
                        </div>

                        @if($module['description'])
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                {{ $module['description'] }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $module['is_active'] ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                {{ $module['is_active'] ? 'Active' : 'Inactive' }}
                            </span>

                            @if(!$module['is_core'])
                                <button 
                                    wire:click="uninstallModule({{ $module['id'] }})"
                                    wire:confirm="Are you sure you want to uninstall this module?"
                                    class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                >
                                    Uninstall
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        No modules installed
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Available Modules --}}
        @if(count($availableModules) > 0)
            <div>
                <h2 class="text-lg font-semibold mb-4">Available Modules</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($availableModules as $module)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold">{{ $module['name'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Version {{ $module['version'] }}
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <button 
                                    wire:click="installModule('{{ $module['name'] }}')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                >
                                    Install
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>