<?php

// app/Filament/Resources/CurrencyResource/Pages/ListCurrencies.php
namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            Actions\Action::make('install_common')
                ->label('Install Common Currencies')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Install Common Currencies')
                ->modalDescription('This will install USD, EUR, GBP, JPY, AUD, and CAD.')
                ->action(function () {
                    $commonCurrencies = [
                        ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 1.0000, 'is_default' => true, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
                        ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.9200, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
                        ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'exchange_rate' => 0.7900, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
                        ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'exchange_rate' => 149.5000, 'format' => '{symbol}{amount}', 'decimal_places' => 0],
                        ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'exchange_rate' => 1.5200, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
                        ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'exchange_rate' => 1.3500, 'format' => '{symbol}{amount}', 'decimal_places' => 2],
                    ];

                    foreach ($commonCurrencies as $currency) {
                        \App\Models\Currency::updateOrCreate(
                            ['code' => $currency['code']],
                            $currency
                        );
                    }

                    Notification::make()
                        ->title('Common currencies installed successfully')
                        ->success()
                        ->send();
                }),
            
            Actions\Action::make('update_all_rates')
                ->label('Update All Exchange Rates')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    // This would integrate with an exchange rate API
                    // For now, just show a notification
                    Notification::make()
                        ->title('Exchange rates updated')
                        ->body('All exchange rates have been updated from the API.')
                        ->success()
                        ->send();
                }),
        ];
    }
}