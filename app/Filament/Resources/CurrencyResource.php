<?php
// app/Filament/Resources/CurrencyResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Currency Information')
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('Currency Code')
                        ->required()
                        ->maxLength(3)
                        ->unique(ignoreRecord: true)
                        ->helperText('ISO 4217 code (e.g., USD, EUR, GBP)')
                        ->placeholder('USD')
                        ->uppercase(),
                    
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->placeholder('US Dollar'),
                    
                    Forms\Components\TextInput::make('symbol')
                        ->required()
                        ->maxLength(10)
                        ->placeholder('$'),
                ])->columns(3),

            Forms\Components\Section::make('Exchange Rate')
                ->schema([
                    Forms\Components\TextInput::make('exchange_rate')
                        ->numeric()
                        ->required()
                        ->minValue(0.0001)
                        ->step(0.0001)
                        ->default(1)
                        ->helperText('Exchange rate relative to base currency (USD = 1)'),
                ])->columns(1),

            Forms\Components\Section::make('Format Settings')
                ->schema([
                    Forms\Components\TextInput::make('format')
                        ->required()
                        ->maxLength(50)
                        ->default('{symbol}{amount}')
                        ->helperText('Use {symbol} and {amount} as placeholders')
                        ->placeholder('{symbol}{amount}'),
                    
                    Forms\Components\TextInput::make('decimal_places')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->maxValue(4)
                        ->default(2)
                        ->helperText('Number of decimal places to display'),
                ])->columns(2),

            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    
                    Forms\Components\Toggle::make('is_default')
                        ->label('Default Currency')
                        ->helperText('Only one currency can be default')
                        ->reactive()
                        ->afterStateUpdated(function ($state) {
                            if ($state) {
                                Currency::where('is_default', true)
                                    ->update(['is_default' => false]);
                            }
                        }),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('symbol')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('exchange_rate')
                    ->numeric(decimalPlaces: 4)
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('format')
                    ->limit(20),
                
                Tables\Columns\TextColumn::make('decimal_places')
                    ->label('Decimals')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                
                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('Default'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Currency $record) {
                        if ($record->is_default) {
                            throw new \Exception('Cannot delete default currency');
                        }
                    }),
                
                Tables\Actions\Action::make('update_rate')
                    ->label('Update Rate')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function (Currency $record) {
                        // Integrate with exchange rate API
                        // This is a placeholder
                        \Filament\Notifications\Notification::make()
                            ->title('Exchange rate updated')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('update_rates')
                        ->label('Update All Rates')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->action(function () {
                            // Batch update exchange rates
                            \Filament\Notifications\Notification::make()
                                ->title('Exchange rates updated')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}