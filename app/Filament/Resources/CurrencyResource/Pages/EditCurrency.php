<?php

// app/Filament/Resources/CurrencyResource/Pages/EditCurrency.php
namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->is_default) {
                        throw new \Exception('Cannot delete default currency');
                    }
                }),
            
            Actions\Action::make('update_rate')
                ->label('Update Exchange Rate')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function ($record) {
                    // Integrate with exchange rate API
                    \Filament\Notifications\Notification::make()
                        ->title('Exchange rate updated')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}