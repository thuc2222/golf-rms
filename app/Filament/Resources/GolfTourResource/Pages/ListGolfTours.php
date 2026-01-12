<?php

// app/Filament/Resources/GolfTourResource/Pages/ListGolfTours.php
namespace App\Filament\Resources\GolfTourResource\Pages;

use App\Filament\Resources\GolfTourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGolfTours extends ListRecords
{
    protected static string $resource = GolfTourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}