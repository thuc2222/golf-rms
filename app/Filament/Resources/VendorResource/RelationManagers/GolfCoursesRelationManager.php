<?php
// app/Filament/Resources/VendorResource/RelationManagers/GolfCoursesRelationManager.php
namespace App\Filament\Resources\VendorResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GolfCoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'golfCourses';
    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('holes_count')
                    ->label('Holes')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('course_type')
                    ->badge(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),
                
                Tables\Columns\TextColumn::make('rating')
                    ->numeric(decimalPlaces: 1),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.golf-courses.view', $record)),
                Tables\Actions\EditAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.golf-courses.edit', $record)),
            ]);
    }
}