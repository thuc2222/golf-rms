<?php
// app/Filament/Pages/Settings.php
namespace App\Filament\Pages;

use App\Models\Language;
use App\Models\Currency;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'System';
    protected static string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => config('app.name'),
            'site_email' => config('mail.from.address'),
            'default_language' => Language::where('is_default', true)->first()?->code ?? 'en',
            'default_currency' => Currency::where('is_default', true)->first()?->code ?? 'usd',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('site_email')
                                    ->email()
                                    ->required(),
                                
                                Forms\Components\TextInput::make('contact_phone')
                                    ->tel()
                                    ->maxLength(20),
                                
                                Forms\Components\Textarea::make('site_description')
                                    ->maxLength(500),
                                
                                Forms\Components\FileUpload::make('site_logo')
                                    ->image()
                                    ->directory('settings'),
                                
                                Forms\Components\FileUpload::make('site_favicon')
                                    ->image()
                                    ->directory('settings'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Localization')
                            ->schema([
                                Forms\Components\Select::make('default_language')
                                    ->options(Language::active()->pluck('name', 'code'))
                                    ->required(),
                                
                                Forms\Components\Select::make('default_currency')
                                    ->options(Currency::active()->pluck('name', 'code'))
                                    ->required(),
                                
                                Forms\Components\Select::make('timezone')
                                    ->options(collect(timezone_identifiers_list())->mapWithKeys(fn ($tz) => [$tz => $tz]))
                                    ->searchable()
                                    ->default('UTC')
                                    ->required(),
                                
                                Forms\Components\Select::make('date_format')
                                    ->options([
                                        'Y-m-d' => 'YYYY-MM-DD',
                                        'd/m/Y' => 'DD/MM/YYYY',
                                        'm/d/Y' => 'MM/DD/YYYY',
                                    ])
                                    ->default('Y-m-d')
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Booking')
                            ->schema([
                                Forms\Components\TextInput::make('min_booking_hours')
                                    ->label('Minimum Hours Before Booking')
                                    ->numeric()
                                    ->default(24)
                                    ->suffix('hours'),
                                
                                Forms\Components\TextInput::make('max_booking_months')
                                    ->label('Maximum Months for Advance Booking')
                                    ->numeric()
                                    ->default(3)
                                    ->suffix('months'),
                                
                                Forms\Components\TextInput::make('cancellation_hours')
                                    ->label('Free Cancellation Period')
                                    ->numeric()
                                    ->default(48)
                                    ->suffix('hours'),
                                
                                Forms\Components\TextInput::make('tax_rate')
                                    ->numeric()
                                    ->suffix('%')
                                    ->default(10),
                                
                                Forms\Components\Toggle::make('auto_confirm_bookings')
                                    ->label('Auto-confirm Bookings')
                                    ->default(false),
                                
                                Forms\Components\Toggle::make('require_payment_upfront')
                                    ->label('Require Payment Upfront')
                                    ->default(false),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Payment')
                            ->schema([
                                Forms\Components\Toggle::make('stripe_enabled')
                                    ->label('Enable Stripe')
                                    ->reactive(),
                                
                                Forms\Components\TextInput::make('stripe_key')
                                    ->label('Stripe Publishable Key')
                                    ->visible(fn (Forms\Get $get) => $get('stripe_enabled')),
                                
                                Forms\Components\TextInput::make('stripe_secret')
                                    ->label('Stripe Secret Key')
                                    ->password()
                                    ->visible(fn (Forms\Get $get) => $get('stripe_enabled')),
                                
                                Forms\Components\Toggle::make('paypal_enabled')
                                    ->label('Enable PayPal')
                                    ->reactive(),
                                
                                Forms\Components\TextInput::make('paypal_client_id')
                                    ->label('PayPal Client ID')
                                    ->visible(fn (Forms\Get $get) => $get('paypal_enabled')),
                                
                                Forms\Components\TextInput::make('paypal_secret')
                                    ->label('PayPal Secret')
                                    ->password()
                                    ->visible(fn (Forms\Get $get) => $get('paypal_enabled')),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Email')
                            ->schema([
                                Forms\Components\Select::make('mail_driver')
                                    ->options([
                                        'smtp' => 'SMTP',
                                        'mailgun' => 'Mailgun',
                                        'ses' => 'Amazon SES',
                                    ])
                                    ->default('smtp')
                                    ->reactive(),
                                
                                Forms\Components\TextInput::make('mail_host')
                                    ->visible(fn (Forms\Get $get) => $get('mail_driver') === 'smtp'),
                                
                                Forms\Components\TextInput::make('mail_port')
                                    ->numeric()
                                    ->visible(fn (Forms\Get $get) => $get('mail_driver') === 'smtp'),
                                
                                Forms\Components\TextInput::make('mail_username')
                                    ->visible(fn (Forms\Get $get) => $get('mail_driver') === 'smtp'),
                                
                                Forms\Components\TextInput::make('mail_password')
                                    ->password()
                                    ->visible(fn (Forms\Get $get) => $get('mail_driver') === 'smtp'),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Save to config or database
        // Implementation depends on your settings storage strategy

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}