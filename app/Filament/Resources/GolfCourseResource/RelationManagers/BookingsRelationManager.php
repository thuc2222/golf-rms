<?php
// app/Filament/Resources/GolfCourseResource/RelationManagers/BookingsRelationManager.php
namespace App\Filament\Resources\GolfCourseResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';
    protected static ?string $recordTitleAttribute = 'booking_number';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('booking_date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('booking_time')
                    ->time(),
                
                Tables\Columns\TextColumn::make('players_count')
                    ->label('Players'),
                
                Tables\Columns\TextColumn::make('total')
                    ->money('usd'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                        'info' => 'completed',
                    ]),
                
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'info' => 'refunded',
                        'danger' => 'failed',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
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
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.bookings.view', $record)),
            ])
            ->defaultSort('booking_date', 'desc');
    }
}