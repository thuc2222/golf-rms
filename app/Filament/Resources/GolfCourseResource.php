<?php

// app/Filament/Resources/GolfCourseResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\GolfCourseResource\Pages;
use App\Filament\Resources\GolfCourseResource\RelationManagers;
use App\Models\GolfCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GolfCourseResource extends Resource
{
    protected static ?string $model = GolfCourse::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Golf Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Information')
                ->schema([
                    Forms\Components\Select::make('vendor_id')
                        ->relationship('vendor', 'business_name')
                        ->searchable()
                        ->required()
                        ->preload(),
                    
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                            $set('slug', \Illuminate\Support\Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'archived' => 'Archived',
                        ])
                        ->default('draft')
                        ->required(),
                    
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured Course'),
                ])->columns(2),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('featured_image')
                        ->image()
                        ->directory('golf-courses/featured')
                        ->maxSize(5120),
                    
                    Forms\Components\FileUpload::make('gallery')
                        ->image()
                        ->multiple()
                        ->directory('golf-courses/gallery')
                        ->maxFiles(10)
                        ->maxSize(5120)
                        ->reorderable(),
                ])->columns(1),

            Forms\Components\Section::make('Contact Information')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                    
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('website')
                        ->url()
                        ->maxLength(255),
                ])->columns(3),

            Forms\Components\Section::make('Location')
                ->schema([
                    Forms\Components\KeyValue::make('address')
                        ->keyLabel('Field')
                        ->valueLabel('Value')
                        ->default([
                            'street' => '',
                            'city' => '',
                            'state' => '',
                            'zip' => '',
                            'country' => '',
                        ]),
                    
                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->step(0.0000001),
                    
                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->step(0.0000001),
                ])->columns(3),

            Forms\Components\Section::make('Course Details')
                ->schema([
                    Forms\Components\TextInput::make('holes_count')
                        ->numeric()
                        ->default(18)
                        ->required(),
                    
                    Forms\Components\TextInput::make('par')
                        ->maxLength(10),
                    
                    Forms\Components\Select::make('course_type')
                        ->options([
                            'championship' => 'Championship',
                            'resort' => 'Resort',
                            'municipal' => 'Municipal',
                            'private' => 'Private',
                            'semi_private' => 'Semi-Private',
                        ]),
                    
                    Forms\Components\CheckboxList::make('facilities')
                        ->options([
                            'driving_range' => 'Driving Range',
                            'putting_green' => 'Putting Green',
                            'chipping_area' => 'Chipping Area',
                            'club_house' => 'Club House',
                            'pro_shop' => 'Pro Shop',
                            'restaurant' => 'Restaurant',
                            'bar' => 'Bar',
                            'locker_room' => 'Locker Room',
                            'cart_rental' => 'Cart Rental',
                            'club_rental' => 'Club Rental',
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                    
                    Forms\Components\CheckboxList::make('amenities')
                        ->options([
                            'parking' => 'Parking',
                            'wifi' => 'WiFi',
                            'golf_lessons' => 'Golf Lessons',
                            'caddie_service' => 'Caddie Service',
                            'electric_carts' => 'Electric Carts',
                            'club_fitting' => 'Club Fitting',
                            'events' => 'Events & Tournaments',
                        ])
                        ->columns(2)
                        ->columnSpanFull(),
                ])->columns(3),

            Forms\Components\Section::make('Operating Hours')
                ->schema([
                    Forms\Components\Repeater::make('operating_hours')
                        ->schema([
                            Forms\Components\Select::make('day')
                                ->options([
                                    'monday' => 'Monday',
                                    'tuesday' => 'Tuesday',
                                    'wednesday' => 'Wednesday',
                                    'thursday' => 'Thursday',
                                    'friday' => 'Friday',
                                    'saturday' => 'Saturday',
                                    'sunday' => 'Sunday',
                                ])
                                ->required(),
                            
                            Forms\Components\TimePicker::make('open')
                                ->required(),
                            
                            Forms\Components\TimePicker::make('close')
                                ->required(),
                            
                            Forms\Components\Toggle::make('is_closed')
                                ->label('Closed'),
                        ])
                        ->columns(4)
                        ->defaultItems(7)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('vendor.business_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('holes_count')
                    ->label('Holes')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('course_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'championship' => 'success',
                        'resort' => 'info',
                        default => 'gray',
                    }),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                
                Tables\Columns\TextColumn::make('rating')
                    ->numeric(decimalPlaces: 1)
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                
                Tables\Filters\SelectFilter::make('vendor')
                    ->relationship('vendor', 'business_name')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\HolesRelationManager::class,
            RelationManagers\TeeTimesRelationManager::class,
            RelationManagers\BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGolfCourses::route('/'),
            'create' => Pages\CreateGolfCourse::route('/create'),
            'edit' => Pages\EditGolfCourse::route('/{record}/edit'),
            'view' => Pages\ViewGolfCourse::route('/{record}'),
        ];
    }
}