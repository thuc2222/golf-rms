<?php
// app/Filament/Resources/GolfTourResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\GolfTourResource\Pages;
use App\Models\GolfTour;
use App\Models\GolfCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GolfTourResource extends Resource
{
    protected static ?string $model = GolfTour::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Golf Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Tour Information')
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
                    
                    Forms\Components\RichEditor::make('itinerary')
                        ->label('Detailed Itinerary')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('featured_image')
                        ->image()
                        ->directory('golf-tours/featured')
                        ->maxSize(5120),
                    
                    Forms\Components\FileUpload::make('gallery')
                        ->image()
                        ->multiple()
                        ->directory('golf-tours/gallery')
                        ->maxFiles(10)
                        ->maxSize(5120)
                        ->reorderable(),
                ])->columns(1),

            Forms\Components\Section::make('Tour Details')
                ->schema([
                    Forms\Components\TextInput::make('duration_days')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->suffix('days'),
                    
                    Forms\Components\TextInput::make('duration_nights')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->suffix('nights'),
                    
                    Forms\Components\TextInput::make('rounds_of_golf')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->suffix('rounds'),
                    
                    Forms\Components\TextInput::make('price_from')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->minValue(0)
                        ->helperText('Starting price per person'),
                    
                    Forms\Components\TextInput::make('min_participants')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->default(1),
                    
                    Forms\Components\TextInput::make('max_participants')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->default(20),
                ])->columns(3),

            Forms\Components\Section::make('Golf Courses')
                ->schema([
                    Forms\Components\Select::make('included_courses')
                        ->label('Included Golf Courses')
                        ->multiple()
                        ->options(GolfCourse::published()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->helperText('Select the golf courses included in this tour')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Inclusions & Exclusions')
                ->schema([
                    Forms\Components\TagsInput::make('inclusions')
                        ->placeholder('Add inclusion (press Enter)')
                        ->helperText('What is included in the tour price')
                        ->default(['Accommodation', 'Green Fees', 'Breakfast'])
                        ->columnSpanFull(),
                    
                    Forms\Components\TagsInput::make('exclusions')
                        ->placeholder('Add exclusion (press Enter)')
                        ->helperText('What is NOT included in the tour price')
                        ->default(['Airfare', 'Lunch & Dinner', 'Personal Expenses'])
                        ->columnSpanFull(),
                ])->columns(1),

            Forms\Components\Section::make('Tour Settings')
                ->schema([
                    Forms\Components\Select::make('difficulty_level')
                        ->options([
                            'beginner' => 'Beginner',
                            'intermediate' => 'Intermediate',
                            'advanced' => 'Advanced',
                            'all_levels' => 'All Levels',
                        ])
                        ->default('all_levels')
                        ->required(),
                    
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'archived' => 'Archived',
                        ])
                        ->default('draft')
                        ->required(),
                    
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured Tour'),
                    
                    Forms\Components\DatePicker::make('available_from')
                        ->label('Available From Date')
                        ->native(false),
                    
                    Forms\Components\DatePicker::make('available_to')
                        ->label('Available Until Date')
                        ->native(false),
                ])->columns(3),
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
                    ->sortable()
                    ->limit(40),
                
                Tables\Columns\TextColumn::make('vendor.business_name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Duration')
                    ->formatStateUsing(fn ($record) => "{$record->duration_days}D/{$record->duration_nights}N")
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('rounds_of_golf')
                    ->label('Rounds')
                    ->suffix(' rounds')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('price_from')
                    ->label('From')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('difficulty_level')
                    ->colors([
                        'success' => 'beginner',
                        'warning' => 'intermediate',
                        'danger' => 'advanced',
                        'info' => 'all_levels',
                    ]),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),
                
                Tables\Columns\TextColumn::make('rating')
                    ->numeric(decimalPlaces: 1)
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
                
                Tables\Filters\SelectFilter::make('difficulty_level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                        'all_levels' => 'All Levels',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                
                Tables\Filters\SelectFilter::make('vendor')
                    ->relationship('vendor', 'business_name')
                    ->searchable()
                    ->preload(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGolfTours::route('/'),
            'create' => Pages\CreateGolfTour::route('/create'),
            'edit' => Pages\EditGolfTour::route('/{record}/edit'),
            'view' => Pages\ViewGolfTour::route('/{record}'),
        ];
    }
}