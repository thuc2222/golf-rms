<?php
// app/Http/Controllers/CurrencyController.php
namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function switch($code)
    {
        try {
            $currency = $this->currencyService->getCurrency($code);
            session(['currency' => $code]);
            
            return back()->with('success', 'Currency changed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Currency not found']);
        }
    }
}