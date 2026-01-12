<?php
// app/Filament/Resources/BookingResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Bookings';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Booking Information')
                ->schema([
                    Forms\Components\TextInput::make('booking_number')
                        ->disabled()
                        ->dehydrated(false),
                    
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required()
                        ->preload(),
                    
                    Forms\Components\Select::make('golf_course_id')
                        ->relationship('golfCourse', 'name')
                        ->searchable()
                        ->required()
                        ->preload()
                        ->reactive(),
                    
                    Forms\Components\Select::make('tee_time_id')
                        ->relationship('teeTime', 'time')
                        ->searchable()
                        ->preload()
                        ->reactive(),
                    
                    Forms\Components\DatePicker::make('booking_date')
                        ->required()
                        ->native(false),
                    
                    Forms\Components\TimePicker::make('booking_time')
                        ->required(),
                    
                    Forms\Components\TextInput::make('players_count')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->maxValue(4)
                        ->default(1),
                ])->columns(2),

            Forms\Components\Section::make('Pricing')
                ->schema([
                    Forms\Components\TextInput::make('subtotal')
                        ->numeric()
                        ->prefix('$')
                        ->required(),
                    
                    Forms\Components\TextInput::make('tax')
                        ->numeric()
                        ->prefix('$')
                        ->default(0),
                    
                    Forms\Components\TextInput::make('discount')
                        ->numeric()
                        ->prefix('$')
                        ->default(0),
                    
                    Forms\Components\TextInput::make('total')
                        ->numeric()
                        ->prefix('$')
                        ->required(),
                    
                    Forms\Components\Select::make('currency')
                        ->options([
                            'usd' => 'USD',
                            'eur' => 'EUR',
                            'gbp' => 'GBP',
                            'jpy' => 'JPY',
                        ])
                        ->default('usd')
                        ->required(),
                ])->columns(3),

            Forms\Components\Section::make('Status')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                            'no_show' => 'No Show',
                        ])
                        ->default('pending')
                        ->required(),
                    
                    Forms\Components\Select::make('payment_status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'refunded' => 'Refunded',
                            'failed' => 'Failed',
                        ])
                        ->default('pending')
                        ->required(),
                    
                    Forms\Components\TextInput::make('payment_method')
                        ->maxLength(255),
                ])->columns(3),

            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\Textarea::make('customer_notes')
                        ->columnSpanFull(),
                    
                    Forms\Components\Textarea::make('admin_notes')
                        ->columnSpanFull(),
                    
                    Forms\Components\KeyValue::make('additional_services')
                        ->keyLabel('Service')
                        ->valueLabel('Details')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('golfCourse.name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('booking_time')
                    ->time()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('players_count')
                    ->label('Players')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                        'info' => 'completed',
                        'secondary' => 'no_show',
                    ]),
                
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'info' => 'refunded',
                        'danger' => 'failed',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                        'no_show' => 'No Show',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                        'failed' => 'Failed',
                    ]),
                
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('booking_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('booking_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('confirm')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Booking $record) => $record->update([
                            'status' => 'confirmed',
                            'confirmed_at' => now(),
                        ]))
                        ->visible(fn (Booking $record) => $record->status === 'pending'),
                    
                    Tables\Actions\Action::make('cancel')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Textarea::make('cancellation_reason')
                                ->required(),
                        ])
                        ->action(function (Booking $record, array $data) {
                            $record->update([
                                'status' => 'cancelled',
                                'cancelled_at' => now(),
                                'cancellation_reason' => $data['cancellation_reason'],
                            ]);
                        })
                        ->visible(fn (Booking $record) => !in_array($record->status, ['cancelled', 'completed'])),
                ]),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
            'view' => Pages\ViewBooking::route('/{record}'),
        ];
    }
}