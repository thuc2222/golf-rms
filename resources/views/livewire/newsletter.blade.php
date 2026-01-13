{{-- resources/views/livewire/newsletter.blade.php --}}
<div>
    @if($subscribed)
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            Thanks for subscribing!
        </div>
    @else
        <form wire:submit="subscribe" class="space-y-2">
            <input 
                type="email" 
                wire:model="email"
                placeholder="Enter your email"
                class="w-full rounded-md border-gray-600 bg-gray-700 text-white placeholder-gray-400 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
            >
            @error('email')
                <p class="text-red-400 text-xs">{{ $message }}</p>
            @enderror
            <button 
                type="submit"
                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-md text-sm"
            >
                Subscribe
            </button>
        </form>
    @endif
</div>