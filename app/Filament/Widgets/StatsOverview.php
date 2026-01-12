<?php
// app/Filament/Widgets/StatsOverview.php
namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\GolfCourse;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Bookings', Booking::count())
                ->description('All time bookings')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            
            Stat::make('Today\'s Bookings', Booking::whereDate('booking_date', today())->count())
                ->description('Bookings for today')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            
            Stat::make('Golf Courses', GolfCourse::where('status', 'published')->count())
                ->description('Published courses')
                ->descriptionIcon('heroicon-m-flag')
                ->color('warning'),
            
            Stat::make('Active Vendors', Vendor::where('status', 'approved')->count())
                ->description('Approved vendors')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),
        ];
    }
}