<?php

// app/Filament/Resources/SubscriptionPlanResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionPlanResource\Pages;
use App\Models\SubscriptionPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Plan Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                            $set('slug', \Illuminate\Support\Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(100),
                    
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Pricing')
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->minValue(0),
                    
                    Forms\Components\Select::make('billing_cycle')
                        ->options([
                            'monthly' => 'Monthly',
                            'quarterly' => 'Quarterly',
                            'yearly' => 'Yearly',
                        ])
                        ->default('monthly')
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Limits')
                ->schema([
                    Forms\Components\TextInput::make('course_limit')
                        ->label('Golf Courses Limit')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->default(1)
                        ->helperText('Maximum number of golf courses vendor can create'),
                    
                    Forms\Components\TextInput::make('booking_limit')
                        ->label('Monthly Booking Limit')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->default(100)
                        ->helperText('Maximum number of bookings per month'),
                ])->columns(2),

            Forms\Components\Section::make('Features')
                ->schema([
                    Forms\Components\KeyValue::make('features')
                        ->keyLabel('Feature')
                        ->valueLabel('Value')
                        ->addActionLabel('Add Feature')
                        ->reorderable()
                        ->default([
                            'Analytics Dashboard' => 'true',
                            'Email Support' => 'true',
                            'API Access' => 'false',
                            'Custom Branding' => 'false',
                        ])
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured Plan')
                        ->helperText('Featured plans are highlighted to customers'),
                    
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first'),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('billing_cycle')
                    ->colors([
                        'primary' => 'monthly',
                        'success' => 'quarterly',
                        'warning' => 'yearly',
                    ]),
                
                Tables\Columns\TextColumn::make('course_limit')
                    ->label('Courses')
                    ->suffix(' courses')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('booking_limit')
                    ->label('Bookings/mo')
                    ->suffix(' bookings')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                
                Tables\Filters\SelectFilter::make('billing_cycle')
                    ->options([
                        'monthly' => 'Monthly',
                        'quarterly' => 'Quarterly',
                        'yearly' => 'Yearly',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}