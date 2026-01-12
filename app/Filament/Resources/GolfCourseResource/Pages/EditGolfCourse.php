<?php

// app/Filament/Resources/GolfCourseResource/Pages/EditGolfCourse.php
namespace App\Filament\Resources\GolfCourseResource\Pages;

use App\Filament\Resources\GolfCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGolfCourse extends EditRecord
{
    protected static string $resource = GolfCourseResource::class;

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