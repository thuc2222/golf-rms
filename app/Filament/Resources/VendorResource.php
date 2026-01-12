<?php

// app/Filament/Resources/VendorResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Vendor Information')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required()
                        ->preload(),
                    
                    Forms\Components\TextInput::make('business_name')
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
                ])->columns(2),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->directory('vendors/logos')
                        ->maxSize(2048),
                    
                    Forms\Components\FileUpload::make('banner')
                        ->image()
                        ->directory('vendors/banners')
                        ->maxSize(5120),
                ])->columns(2),

            Forms\Components\Section::make('Contact')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                    
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    
                    Forms\Components\TextInput::make('website')
                        ->url()
                        ->maxLength(255),
                    
                    Forms\Components\KeyValue::make('address')
                        ->keyLabel('Field')
                        ->valueLabel('Value')
                        ->columnSpanFull(),
                ])->columns(3),

            Forms\Components\Section::make('Business Settings')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            'suspended' => 'Suspended',
                        ])
                        ->default('pending')
                        ->required(),
                    
                    Forms\Components\TextInput::make('commission_rate')
                        ->numeric()
                        ->suffix('%')
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(10),
                    
                    Forms\Components\FileUpload::make('business_documents')
                        ->multiple()
                        ->directory('vendors/documents')
                        ->maxFiles(5)
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('commission_rate')
                    ->suffix('%')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'secondary' => 'suspended',
                    ]),
                
                Tables\Columns\TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Vendor $record) => $record->update([
                            'status' => 'approved',
                            'verified_at' => now(),
                        ]))
                        ->visible(fn (Vendor $record) => $record->status === 'pending'),
                    
                    Tables\Actions\Action::make('reject')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Vendor $record) => $record->update(['status' => 'rejected']))
                        ->visible(fn (Vendor $record) => $record->status === 'pending'),
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
            'index' => Pages\ListVendors::route('/'),
            'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
            'view' => Pages\ViewVendor::route('/{record}'),
        ];
    }
}