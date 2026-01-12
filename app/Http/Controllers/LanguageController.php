<?php
// app/Http/Controllers/LanguageController.php
namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function switch($code)
    {
        try {
            $this->languageService->setLanguage($code);
            
            return back()->with('success', 'Language changed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Language not found']);
        }
    }
}