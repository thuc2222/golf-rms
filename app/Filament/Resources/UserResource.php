<?php
// app/Filament/Resources/UserResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                    
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required(fn ($context) => $context === 'create')
                        ->minLength(8)
                        ->dehydrated(fn ($state) => filled($state)),
                ])->columns(2),

            Forms\Components\Section::make('Account Settings')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->options([
                            'customer' => 'Customer',
                            'vendor' => 'Vendor',
                            'admin' => 'Admin',
                        ])
                        ->default('customer')
                        ->required(),
                    
                    Forms\Components\Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'banned' => 'Banned',
                        ])
                        ->default('active')
                        ->required(),
                    
                    Forms\Components\FileUpload::make('avatar')
                        ->image()
                        ->directory('avatars')
                        ->maxSize(2048),
                ])->columns(3),

            Forms\Components\Section::make('Preferences')
                ->schema([
                    Forms\Components\Select::make('preferred_language')
                        ->options(fn () => \App\Models\Language::active()->pluck('name', 'code'))
                        ->default('en')
                        ->searchable(),
                    
                    Forms\Components\Select::make('preferred_currency')
                        ->options(fn () => \App\Models\Currency::active()->pluck('name', 'code'))
                        ->default('usd')
                        ->searchable(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'secondary' => 'customer',
                        'warning' => 'vendor',
                        'danger' => 'admin',
                    ]),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'secondary' => 'inactive',
                        'danger' => 'banned',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'customer' => 'Customer',
                        'vendor' => 'Vendor',
                        'admin' => 'Admin',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'banned' => 'Banned',
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}