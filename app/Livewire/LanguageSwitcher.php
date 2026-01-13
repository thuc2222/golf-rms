<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $currentLanguage;
    public $languages = [];

    public function mount()
    {
        $this->currentLanguage = App::getLocale();
        
        // Define available languages
        $this->languages = [
            'en' => ['name' => 'English', 'flag' => '🇺🇸'],
            'vi' => ['name' => 'Tiếng Việt', 'flag' => '🇻🇳'],
            // Add more languages as needed
        ];
    }

    public function switchLanguage($locale)
    {
        if (array_key_exists($locale, $this->languages)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            $this->currentLanguage = $locale;
            
            // Refresh the page to apply changes
            return redirect()->to(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}