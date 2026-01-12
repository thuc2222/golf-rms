<?php

// app/Filament/Resources/GolfTourResource/Pages/EditGolfTour.php
namespace App\Filament\Resources\GolfTourResource\Pages;

use App\Filament\Resources\GolfTourResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGolfTour extends EditRecord
{
    protected static string $resource = GolfTourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}