<?php

// app/Filament/Resources/LanguageResource/Pages/ListLanguages.php
namespace App\Filament\Resources\LanguageResource\Pages;

use App\Filament\Resources\LanguageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            Actions\Action::make('install_common')
                ->label('Install Common Languages')
                ->icon('heroicon-o-globe-alt')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Install Common Languages')
                ->modalDescription('This will install English, Spanish, French, German, Arabic, and Chinese.')
                ->action(function () {
                    $commonLanguages = [
                        ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_rtl' => false, 'is_default' => true, 'sort_order' => 0],
                        ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'is_rtl' => false, 'sort_order' => 1],
                        ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français', 'is_rtl' => false, 'sort_order' => 2],
                        ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch', 'is_rtl' => false, 'sort_order' => 3],
                        ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية', 'is_rtl' => true, 'sort_order' => 4],
                        ['code' => 'zh', 'name' => 'Chinese', 'native_name' => '中文', 'is_rtl' => false, 'sort_order' => 5],
                    ];

                    foreach ($commonLanguages as $language) {
                        \App\Models\Language::updateOrCreate(
                            ['code' => $language['code']],
                            $language
                        );
                    }

                    Notification::make()
                        ->title('Common languages installed successfully')
                        ->success()
                        ->send();
                }),
        ];
    }
}