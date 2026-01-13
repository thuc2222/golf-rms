<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CurrencySwitcher extends Component
{
    public $currentCurrency;
    public $currencies = [];

    public function mount()
    {
        $this->currentCurrency = Session::get('currency', 'USD');
        
        // Define available currencies
        $this->currencies = [
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
            'VND' => ['name' => 'Vietnamese Dong', 'symbol' => '₫'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
            // Add more currencies as needed
        ];
    }

    public function switchCurrency($currency)
    {
        if (array_key_exists($currency, $this->currencies)) {
            Session::put('currency', $currency);
            $this->currentCurrency = $currency;
            
            // Refresh the page to apply changes
            $this->dispatch('currency-changed', currency: $currency);
            return redirect()->to(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.currency-switcher');
    }
}