@echo off
echo ======================================
echo  Generating Filament Pages (SAFE MODE)
echo ======================================
echo.

REM ===== BOOKING =====
php artisan make:filament-page ListBookings --resource=BookingResource --type=ListRecords
php artisan make:filament-page CreateBooking --resource=BookingResource --type=CreateRecord
php artisan make:filament-page EditBooking --resource=BookingResource --type=EditRecord
php artisan make:filament-page ViewBooking --resource=BookingResource --type=ViewRecord

REM ===== CURRENCY =====
php artisan make:filament-page ListCurrencies --resource=CurrencyResource --type=ListRecords
php artisan make:filament-page CreateCurrency --resource=CurrencyResource --type=CreateRecord
php artisan make:filament-page EditCurrency --resource=CurrencyResource --type=EditRecord
php artisan make:filament-page ViewCurrency --resource=CurrencyResource --type=ViewRecord

REM ===== GOLF COURSE =====
php artisan make:filament-page ListGolfCourses --resource=GolfCourseResource --type=ListRecords
php artisan make:filament-page CreateGolfCourse --resource=GolfCourseResource --type=CreateRecord
php artisan make:filament-page EditGolfCourse --resource=GolfCourseResource --type=EditRecord
php artisan make:filament-page ViewGolfCourse --resource=GolfCourseResource --type=ViewRecord

REM ===== GOLF TOUR =====
php artisan make:filament-page ListGolfTours --resource=GolfTourResource --type=ListRecords
php artisan make:filament-page CreateGolfTour --resource=GolfTourResource --type=CreateRecord
php artisan make:filament-page EditGolfTour --resource=GolfTourResource --type=EditRecord
php artisan make:filament-page ViewGolfTour --resource=GolfTourResource --type=ViewRecord

REM ===== LANGUAGE =====
php artisan make:filament-page ListLanguages --resource=LanguageResource --type=ListRecords
php artisan make:filament-page CreateLanguage --resource=LanguageResource --type=CreateRecord
php artisan make:filament-page EditLanguage --resource=LanguageResource --type=EditRecord
php artisan make:filament-page ViewLanguage --resource=LanguageResource --type=ViewRecord

REM ===== SUBSCRIPTION PLAN =====
php artisan make:filament-page ListSubscriptionPlans --resource=SubscriptionPlanResource --type=ListRecords
php artisan make:filament-page CreateSubscriptionPlan --resource=SubscriptionPlanResource --type=CreateRecord
php artisan make:filament-page EditSubscriptionPlan --resource=SubscriptionPlanResource --type=EditRecord
php artisan make:filament-page ViewSubscriptionPlan --resource=SubscriptionPlanResource --type=ViewRecord

REM ===== USER =====
php artisan make:filament-page ListUsers --resource=UserResource --type=ListRecords
php artisan make:filament-page CreateUser --resource=UserResource --type=CreateRecord
php artisan make:filament-page EditUser --resource=UserResource --type=EditRecord
php artisan make:filament-page ViewUser --resource=UserResource --type=ViewRecord

REM ===== VENDOR =====
php artisan make:filament-page ListVendors --resource=VendorResource --type=ListRecords
php artisan make:filament-page CreateVendor --resource=VendorResource --type=CreateRecord
php artisan make:filament-page EditVendor --resource=VendorResource --type=EditRecord
php artisan make:filament-page ViewVendor --resource=VendorResource --type=ViewRecord

echo.
echo ======================================
echo  DONE! Clearing cache...
echo ======================================

composer dump-autoload
php artisan optimize:clear
php artisan route:clear

echo.
echo ======================================
echo  FINISHED SUCCESSFULLY
echo ======================================
pause
