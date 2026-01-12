<?php

// app/Filament/Resources/GolfCourseResource/RelationManagers/TeeTimesRelationManager.php
namespace App\Filament\Resources\GolfCourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TeeTimesRelationManager extends RelationManager
{
    protected static string $relationship = 'teeTimes';
    protected static ?string $recordTitleAttribute = 'time';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('date')
                ->required()
                ->native(false)
                ->minDate(today()),
            
            Forms\Components\TimePicker::make('time')
                ->required()
                ->minutesStep(15),
            
            Forms\Components\TextInput::make('available_slots')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(10)
                ->default(4),
            
            Forms\Components\TextInput::make('booked_slots')
                ->numeric()
                ->disabled()
                ->default(0),
            
            Forms\Components\TextInput::make('price')
                ->numeric()
                ->prefix('$')
                ->required()
                ->minValue(0),
            
            Forms\Components\TextInput::make('weekend_price')
                ->numeric()
                ->prefix('$')
                ->minValue(0)
                ->helperText('Leave empty to use regular price'),
            
            Forms\Components\Toggle::make('is_available')
                ->label('Available for Booking')
                ->default(true),
            
            Forms\Components\Textarea::make('notes')
                ->maxLength(500),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('time')
                    ->time()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('available_slots')
                    ->label('Slots')
                    ->formatStateUsing(fn ($record) => "{$record->booked_slots}/{$record->available_slots}")
                    ->badge()
                    ->color(fn ($record) => 
                        $record->booked_slots >= $record->available_slots ? 'danger' : 
                        ($record->booked_slots > 0 ? 'warning' : 'success')
                    ),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('weekend_price')
                    ->money('usd')
                    ->placeholder('Same as weekday'),
                
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean()
                    ->label('Available'),
            ])
            ->filters([
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->default(today()),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('date', '<=', $date));
                    }),
                
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Available'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                
                Tables\Actions\Action::make('generate_week')
                    ->label('Generate Week Schedule')
                    ->icon('heroicon-o-calendar-days')
                    ->color('success')
                    ->form([
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->native(false)
                            ->minDate(today())
                            ->default(today()),
                        
                        Forms\Components\Select::make('days')
                            ->multiple()
                            ->options([
                                1 => 'Monday',
                                2 => 'Tuesday',
                                3 => 'Wednesday',
                                4 => 'Thursday',
                                5 => 'Friday',
                                6 => 'Saturday',
                                7 => 'Sunday',
                            ])
                            ->default([1, 2, 3, 4, 5, 6, 7])
                            ->required(),
                        
                        Forms\Components\TimePicker::make('start_time')
                            ->required()
                            ->default('08:00'),
                        
                        Forms\Components\TimePicker::make('end_time')
                            ->required()
                            ->default('18:00'),
                        
                        Forms\Components\TextInput::make('interval')
                            ->numeric()
                            ->required()
                            ->default(15)
                            ->suffix('minutes'),
                        
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->default(100),
                        
                        Forms\Components\TextInput::make('weekend_price')
                            ->numeric()
                            ->prefix('$'),
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $startDate = \Carbon\Carbon::parse($data['start_date']);
                        $startTime = \Carbon\Carbon::parse($data['start_time']);
                        $endTime = \Carbon\Carbon::parse($data['end_time']);
                        $interval = $data['interval'];
                        
                        for ($i = 0; $i < 7; $i++) {
                            $currentDate = $startDate->copy()->addDays($i);
                            
                            if (!in_array($currentDate->dayOfWeekIso, $data['days'])) {
                                continue;
                            }
                            
                            $currentTime = $startTime->copy();
                            while ($currentTime->lte($endTime)) {
                                $livewire->getOwnerRecord()->teeTimes()->create([
                                    'date' => $currentDate,
                                    'time' => $currentTime->format('H:i:s'),
                                    'available_slots' => 4,
                                    'booked_slots' => 0,
                                    'price' => $data['price'],
                                    'weekend_price' => $data['weekend_price'],
                                    'is_available' => true,
                                ]);
                                
                                $currentTime->addMinutes($interval);
                            }
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Tee times generated successfully')
                            ->success()
                            ->send();
                    }),
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
            ->defaultSort('date', 'asc');
    }
}