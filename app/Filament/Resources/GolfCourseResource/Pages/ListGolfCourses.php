<?php

// app/Filament/Resources/GolfCourseResource/Pages/ListGolfCourses.php
namespace App\Filament\Resources\GolfCourseResource\Pages;

use App\Filament\Resources\GolfCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGolfCourses extends ListRecords
{
    protected static string $resource = GolfCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}