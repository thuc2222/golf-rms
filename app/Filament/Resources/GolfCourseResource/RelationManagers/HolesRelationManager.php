<?php
// app/Filament/Resources/GolfCourseResource/RelationManagers/HolesRelationManager.php
namespace App\Filament\Resources\GolfCourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HolesRelationManager extends RelationManager
{
    protected static string $relationship = 'holes';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('hole_number')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(18),
            
            Forms\Components\TextInput::make('name')
                ->maxLength(255),
            
            Forms\Components\Textarea::make('description')
                ->columnSpanFull(),
            
            Forms\Components\TextInput::make('par')
                ->numeric()
                ->required()
                ->minValue(3)
                ->maxValue(6),
            
            Forms\Components\KeyValue::make('yardage')
                ->keyLabel('Tee Type')
                ->valueLabel('Yards')
                ->default([
                    'championship' => 0,
                    'regular' => 0,
                    'forward' => 0,
                ])
                ->columnSpanFull(),
            
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('coordinates.x')
                        ->label('X Coordinate')
                        ->numeric(),
                    
                    Forms\Components\TextInput::make('coordinates.y')
                        ->label('Y Coordinate')
                        ->numeric(),
                ]),
            
            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('golf-holes')
                ->maxSize(2048),
            
            Forms\Components\TextInput::make('handicap')
                ->numeric()
                ->minValue(1)
                ->maxValue(18),
            
            Forms\Components\CheckboxList::make('hazards')
                ->options([
                    'bunker' => 'Bunker',
                    'water' => 'Water',
                    'trees' => 'Trees',
                    'rough' => 'Rough',
                    'out_of_bounds' => 'Out of Bounds',
                ])
                ->columns(2)
                ->columnSpanFull(),
            
            Forms\Components\Textarea::make('tips')
                ->label('Playing Tips')
                ->columnSpanFull(),
            
            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hole_number')
                    ->label('Hole')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('par')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('yardage.championship')
                    ->label('Championship')
                    ->suffix(' yds'),
                
                Tables\Columns\TextColumn::make('yardage.regular')
                    ->label('Regular')
                    ->suffix(' yds'),
                
                Tables\Columns\TextColumn::make('handicap')
                    ->sortable(),
                
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
            ])
            ->defaultSort('hole_number')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}