<?php
// app/Services/LanguageService.php
namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LanguageService
{
    public function setLanguage($code)
    {
        $language = $this->getLanguage($code);

        if (!$language) {
            throw new \Exception("Language $code not found or inactive");
        }

        App::setLocale($code);
        Session::put('locale', $code);

        return $language;
    }

    public function getLanguage($code)
    {
        return Cache::remember("language.$code", 3600, function () use ($code) {
            return Language::where('code', $code)
                ->where('is_active', true)
                ->first();
        });
    }

    public function getDefaultLanguage()
    {
        return Cache::remember('language.default', 3600, function () {
            return Language::where('is_default', true)->first();
        });
    }

    public function getActiveLanguages()
    {
        return Cache::remember('languages.active', 3600, function () {
            return Language::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    public function getCurrentLanguage()
    {
        $code = Session::get('locale', App::getLocale());
        return $this->getLanguage($code) ?? $this->getDefaultLanguage();
    }

    public function isRTL($code = null)
    {
        $code = $code ?? App::getLocale();
        $language = $this->getLanguage($code);
        
        return $language ? $language->is_rtl : false;
    }
}