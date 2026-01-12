<?php
// app/Filament/Resources/LanguageResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;
    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Language Information')
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('Language Code')
                        ->required()
                        ->maxLength(10)
                        ->unique(ignoreRecord: true)
                        ->helperText('ISO 639-1 code (e.g., en, fr, de, ar)')
                        ->placeholder('en'),
                    
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->helperText('English name')
                        ->placeholder('English'),
                    
                    Forms\Components\TextInput::make('native_name')
                        ->required()
                        ->maxLength(100)
                        ->helperText('Native name')
                        ->placeholder('English'),
                ])->columns(3),

            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\Toggle::make('is_rtl')
                        ->label('Right-to-Left (RTL)')
                        ->helperText('Enable for languages like Arabic, Hebrew'),
                    
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    
                    Forms\Components\Toggle::make('is_default')
                        ->label('Default Language')
                        ->helperText('Only one language can be default')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                // Unset other defaults when this is set as default
                                Language::where('is_default', true)
                                    ->update(['is_default' => false]);
                            }
                        }),
                    
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Display order (lower appears first)'),
                ])->columns(4),
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
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('native_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_rtl')
                    ->boolean()
                    ->label('RTL'),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
                
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
                
                Tables\Filters\TernaryFilter::make('is_rtl')
                    ->label('RTL'),
                
                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('Default'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Language $record) {
                        if ($record->is_default) {
                            throw new \Exception('Cannot delete default language');
                        }
                    }),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}