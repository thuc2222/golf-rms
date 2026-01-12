<?php
// app/Filament/Resources/VendorResource/RelationManagers/SubscriptionsRelationManager.php
namespace App\Filament\Resources\VendorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('subscription_plan_id')
                ->relationship('subscriptionPlan', 'name')
                ->required()
                ->preload(),
            
            Forms\Components\DateTimePicker::make('started_at')
                ->required()
                ->default(now()),
            
            Forms\Components\DateTimePicker::make('expires_at')
                ->required()
                ->default(now()->addMonth()),
            
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'expired' => 'Expired',
                    'cancelled' => 'Cancelled',
                ])
                ->default('active')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subscriptionPlan.name')
                    ->label('Plan')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('subscriptionPlan.billing_cycle')
                    ->label('Cycle')
                    ->badge(),
                
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'expired',
                        'secondary' => 'cancelled',
                    ]),
                
                Tables\Columns\TextColumn::make('cancelled_at')
                    ->dateTime()
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Tables\Actions\Action::make('cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ]))
                    ->visible(fn ($record) => $record->status === 'active'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}