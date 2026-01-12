<?php

// app/Traits/Translatable.php
namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

trait Translatable
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function getTranslation($field, $locale = null)
    {
        $locale = $locale ?? App::getLocale();
        
        $translation = $this->translations()
            ->where('language_code', $locale)
            ->where('field', $field)
            ->first();
            
        return $translation ? $translation->value : $this->getAttribute($field);
    }

    public function setTranslation($field, $value, $locale)
    {
        return $this->translations()->updateOrCreate(
            [
                'language_code' => $locale,
                'field' => $field,
            ],
            ['value' => $value]
        );
    }

    public function translate($locale = null)
    {
        $locale = $locale ?? App::getLocale();
        
        if (!isset($this->translatable)) {
            return $this;
        }

        foreach ($this->translatable as $field) {
            $this->setAttribute($field, $this->getTranslation($field, $locale));
        }

        return $this;
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        if (isset($this->translatable) && 
            in_array($key, $this->translatable) && 
            !$this->relationLoaded('translations')) {
            return $this->getTranslation($key);
        }

        return $value;
    }
}