<?php

// app/Filament/Resources/GolfTourResource/Pages/ViewGolfTour.php
namespace App\Filament\Resources\GolfTourResource\Pages;

use App\Filament\Resources\GolfTourResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGolfTour extends ViewRecord
{
    protected static string $resource = GolfTourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}