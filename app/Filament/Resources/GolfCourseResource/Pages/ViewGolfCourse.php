<?php

// app/Filament/Resources/GolfCourseResource/Pages/ViewGolfCourse.php
namespace App\Filament\Resources\GolfCourseResource\Pages;

use App\Filament\Resources\GolfCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGolfCourse extends ViewRecord
{
    protected static string $resource = GolfCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}