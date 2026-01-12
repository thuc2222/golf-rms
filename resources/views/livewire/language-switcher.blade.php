<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Language;

class LanguageSwitcher extends Component
{
    public $languages;
    public $currentLanguage;

    public function mount()
    {
        $this->languages = Language::where('is_active', true)->get();

        $this->currentLanguage = Language::where(
            'code',
            app()->getLocale()
        )->first();
    }

    public function switchLanguage(string $code)
    {
        session(['locale' => $code]);
        app()->setLocale($code);

        $this->currentLanguage = Language::where('code', $code)->first();

        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
