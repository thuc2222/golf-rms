<?php

// app/Filament/Resources/GolfTourResource/Pages/CreateGolfTour.php
namespace App\Filament\Resources\GolfTourResource\Pages;

use App\Filament\Resources\GolfTourResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGolfTour extends CreateRecord
{
    protected static string $resource = GolfTourResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}