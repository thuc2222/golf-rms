<?php

// app/Filament/Resources/GolfCourseResource/Pages/CreateGolfCourse.php
namespace App\Filament\Resources\GolfCourseResource\Pages;

use App\Filament\Resources\GolfCourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGolfCourse extends CreateRecord
{
    protected static string $resource = GolfCourseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}