<?php
// app/Services/CurrencyService.php
namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    public function convert($amount, $from, $to)
    {
        if ($from === $to) {
            return $amount;
        }

        $fromCurrency = $this->getCurrency($from);
        $toCurrency = $this->getCurrency($to);

        // Convert to base currency first, then to target
        $baseAmount = $amount / $fromCurrency->exchange_rate;
        return $baseAmount * $toCurrency->exchange_rate;
    }

    public function format($amount, $currencyCode = null)
    {
        $currencyCode = $currencyCode ?? $this->getDefaultCurrency()->code;
        $currency = $this->getCurrency($currencyCode);

        return $currency->format($amount);
    }

    public function getCurrency($code)
    {
        return Cache::remember("currency.$code", 3600, function () use ($code) {
            return Currency::where('code', $code)->firstOrFail();
        });
    }

    public function getDefaultCurrency()
    {
        return Cache::remember('currency.default', 3600, function () {
            return Currency::where('is_default', true)->firstOrFail();
        });
    }

    public function getActiveCurrencies()
    {
        return Cache::remember('currencies.active', 3600, function () {
            return Currency::where('is_active', true)->get();
        });
    }

    public function updateExchangeRates()
    {
        // Integrate with exchange rate API (e.g., exchangerate-api.com)
        // This is a placeholder for actual implementation
        
        $currencies = Currency::where('is_active', true)->get();
        
        foreach ($currencies as $currency) {
            // Fetch and update exchange rate
            // $rate = $this->fetchExchangeRate($currency->code);
            // $currency->update(['exchange_rate' => $rate]);
        }

        Cache::forget('currencies.active');
    }
}