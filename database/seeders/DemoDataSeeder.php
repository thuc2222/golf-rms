<?php

// database/seeders/DemoDataSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Models\GolfCourse;
use App\Models\GolfHole;
use App\Models\GolfTour;
use App\Models\TeeTime;
use App\Models\Booking;
use App\Models\VendorSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🌱 Starting demo data seeding...');

        // Create Demo Users
        $this->createUsers();
        
        // Create Vendors with Subscriptions
        $this->createVendors();
        
        // Create Golf Courses with Holes
        $this->createGolfCourses();
        
        // Create Golf Tours
        $this->createGolfTours();
        
        // Create Tee Times
        $this->createTeeTimes();
        
        // Create Demo Bookings
        $this->createBookings();

        $this->command->info('✅ Demo data seeding completed!');
    }

    protected function createUsers()
    {
        $this->command->info('Creating demo users...');

        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@golftour.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Vendor Users
        $vendorUsers = [
            ['name' => 'Pebble Beach Management', 'email' => 'pebble@golftour.com'],
            ['name' => 'Augusta National', 'email' => 'augusta@golftour.com'],
            ['name' => 'St Andrews Links', 'email' => 'standrews@golftour.com'],
            ['name' => 'Pine Valley Golf Club', 'email' => 'pinevalley@golftour.com'],
        ];

        foreach ($vendorUsers as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'type' => 'vendor',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Customer Users
        $customerNames = [
            'John Smith', 'Emma Wilson', 'Michael Brown', 'Sarah Johnson',
            'David Lee', 'Lisa Anderson', 'James Taylor', 'Emily Martinez',
            'Robert Garcia', 'Jennifer Davis', 'William Rodriguez', 'Mary Thompson',
        ];

        foreach ($customerNames as $name) {
            User::create([
                'name' => $name,
                'email' => Str::slug($name) . '@example.com',
                'password' => Hash::make('password'),
                'type' => 'customer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('✓ Created ' . (count($vendorUsers) + count($customerNames) + 1) . ' users');
    }

    protected function createVendors()
    {
        $this->command->info('Creating vendors...');

        $subscriptionPlans = SubscriptionPlan::all();

        $vendors = [
            [
                'user_id' => 2,
                'business_name' => 'Pebble Beach Golf Resort',
                'slug' => 'pebble-beach-golf-resort',
                'description' => 'Experience world-class golf at one of the most iconic courses in the world. Pebble Beach has been the home of legendary tournaments and unforgettable moments.',
                'phone' => '+1 (831) 624-3811',
                'email' => 'info@pebblebeach.com',
                'website' => 'https://pebblebeach.com',
                'address' => [
                    'street' => '1700 17-Mile Drive',
                    'city' => 'Pebble Beach',
                    'state' => 'California',
                    'zip' => '93953',
                    'country' => 'USA',
                ],
                'status' => 'approved',
                'verified_at' => now(),
            ],
            [
                'user_id' => 3,
                'business_name' => 'Augusta National Golf Club',
                'slug' => 'augusta-national-golf-club',
                'description' => 'Home of The Masters Tournament. Augusta National is one of the most prestigious golf clubs in the world, featuring immaculately manicured fairways and greens.',
                'phone' => '+1 (706) 667-6000',
                'email' => 'contact@augusta.com',
                'website' => 'https://augusta.com',
                'address' => [
                    'street' => '2604 Washington Road',
                    'city' => 'Augusta',
                    'state' => 'Georgia',
                    'zip' => '30904',
                    'country' => 'USA',
                ],
                'status' => 'approved',
                'verified_at' => now(),
            ],
            [
                'user_id' => 4,
                'business_name' => 'St Andrews Links Trust',
                'slug' => 'st-andrews-links-trust',
                'description' => 'The Home of Golf. St Andrews is the most famous golf course in the world, with a history dating back over 600 years.',
                'phone' => '+44 1334 466666',
                'email' => 'info@standrews.com',
                'website' => 'https://standrews.com',
                'address' => [
                    'street' => 'Pilmour House, St Andrews Links',
                    'city' => 'St Andrews',
                    'state' => 'Fife',
                    'zip' => 'KY16 9SF',
                    'country' => 'Scotland',
                ],
                'status' => 'approved',
                'verified_at' => now(),
            ],
            [
                'user_id' => 5,
                'business_name' => 'Pine Valley Golf Club',
                'slug' => 'pine-valley-golf-club',
                'description' => 'Consistently ranked as the #1 golf course in the world. Pine Valley offers an unparalleled golf experience in a pristine natural setting.',
                'phone' => '+1 (856) 309-3022',
                'email' => 'info@pinevalley.com',
                'website' => 'https://pinevalley.com',
                'address' => [
                    'street' => 'Pine Valley Road',
                    'city' => 'Pine Valley',
                    'state' => 'New Jersey',
                    'zip' => '08021',
                    'country' => 'USA',
                ],
                'status' => 'approved',
                'verified_at' => now(),
            ],
        ];

        foreach ($vendors as $vendorData) {
            $vendor = Vendor::create($vendorData);

            // Assign subscription
            VendorSubscription::create([
                'vendor_id' => $vendor->id,
                'subscription_plan_id' => $subscriptionPlans->random()->id,
                'started_at' => now(),
                'expires_at' => now()->addYear(),
                'status' => 'active',
            ]);
        }

        $this->command->info('✓ Created ' . count($vendors) . ' vendors');
    }

    protected function createGolfCourses()
    {
        $this->command->info('Creating golf courses...');

        $courses = [
            [
                'vendor_id' => 1,
                'name' => 'Pebble Beach Golf Links',
                'slug' => 'pebble-beach-golf-links',
                'description' => 'Pebble Beach Golf Links is widely regarded as one of the most beautiful courses in the world. Hugging the rugged coastline, it offers breathtaking views of the Pacific Ocean and challenging holes that have tested the world\'s best golfers.',
                'holes_count' => 18,
                'par' => '72',
                'course_type' => 'championship',
                'address' => ['city' => 'Pebble Beach', 'state' => 'California', 'country' => 'USA'],
                'phone' => '+1 (831) 624-3811',
                'email' => 'golf@pebblebeach.com',
                'facilities' => ['driving_range', 'putting_green', 'club_house', 'pro_shop', 'restaurant', 'cart_rental'],
                'amenities' => ['parking', 'wifi', 'golf_lessons', 'caddie_service', 'electric_carts'],
                'rating' => 4.9,
                'reviews_count' => 2847,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'vendor_id' => 2,
                'name' => 'Augusta National Golf Club',
                'slug' => 'augusta-national-golf-club',
                'description' => 'Augusta National is home to The Masters Tournament and is known for its pristine conditions, azaleas, and iconic holes like Amen Corner. The course was designed by Bobby Jones and Alister MacKenzie.',
                'holes_count' => 18,
                'par' => '72',
                'course_type' => 'championship',
                'address' => ['city' => 'Augusta', 'state' => 'Georgia', 'country' => 'USA'],
                'phone' => '+1 (706) 667-6000',
                'email' => 'golf@augusta.com',
                'facilities' => ['driving_range', 'putting_green', 'chipping_area', 'club_house', 'pro_shop', 'restaurant', 'bar'],
                'amenities' => ['parking', 'golf_lessons', 'caddie_service', 'club_fitting'],
                'rating' => 5.0,
                'reviews_count' => 1523,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'vendor_id' => 3,
                'name' => 'Old Course at St Andrews',
                'slug' => 'old-course-st-andrews',
                'description' => 'The Old Course is the oldest golf course in the world and is considered the "Home of Golf". With its iconic features like the Swilcan Bridge and Hell Bunker, it has hosted The Open Championship more times than any other course.',
                'holes_count' => 18,
                'par' => '72',
                'course_type' => 'championship',
                'address' => ['city' => 'St Andrews', 'state' => 'Fife', 'country' => 'Scotland'],
                'phone' => '+44 1334 466666',
                'email' => 'oldcourse@standrews.com',
                'facilities' => ['driving_range', 'putting_green', 'club_house', 'pro_shop', 'restaurant'],
                'amenities' => ['parking', 'wifi', 'golf_lessons', 'caddie_service'],
                'rating' => 4.8,
                'reviews_count' => 3241,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'vendor_id' => 4,
                'name' => 'Pine Valley Golf Club',
                'slug' => 'pine-valley-golf-club',
                'description' => 'Pine Valley is consistently ranked as the #1 golf course in the world. Set in the New Jersey Pine Barrens, it features dramatic elevation changes and strategic bunkering that challenge even the best golfers.',
                'holes_count' => 18,
                'par' => '70',
                'course_type' => 'private',
                'address' => ['city' => 'Pine Valley', 'state' => 'New Jersey', 'country' => 'USA'],
                'phone' => '+1 (856) 309-3022',
                'email' => 'golf@pinevalley.com',
                'facilities' => ['driving_range', 'putting_green', 'club_house', 'pro_shop', 'restaurant', 'bar', 'locker_room'],
                'amenities' => ['parking', 'golf_lessons', 'caddie_service', 'club_fitting'],
                'rating' => 5.0,
                'reviews_count' => 892,
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'vendor_id' => 1,
                'name' => 'Spyglass Hill Golf Course',
                'slug' => 'spyglass-hill-golf-course',
                'description' => 'Named after Robert Louis Stevenson\'s classic novel "Treasure Island", Spyglass Hill combines breathtaking ocean views with challenging inland holes through the Del Monte Forest.',
                'holes_count' => 18,
                'par' => '72',
                'course_type' => 'resort',
                'address' => ['city' => 'Pebble Beach', 'state' => 'California', 'country' => 'USA'],
                'phone' => '+1 (831) 625-8563',
                'email' => 'spyglass@pebblebeach.com',
                'facilities' => ['driving_range', 'putting_green', 'club_house', 'pro_shop', 'cart_rental'],
                'amenities' => ['parking', 'wifi', 'golf_lessons', 'electric_carts'],
                'rating' => 4.7,
                'reviews_count' => 1654,
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'vendor_id' => 3,
                'name' => 'Castle Course',
                'slug' => 'castle-course',
                'description' => 'The Castle Course offers spectacular views over St Andrews and St Andrews Bay. Designed by renowned architect David McLay Kidd, it provides a modern championship test of golf.',
                'holes_count' => 18,
                'par' => '71',
                'course_type' => 'championship',
                'address' => ['city' => 'St Andrews', 'state' => 'Fife', 'country' => 'Scotland'],
                'phone' => '+44 1334 466666',
                'email' => 'castle@standrews.com',
                'facilities' => ['driving_range', 'putting_green', 'club_house', 'pro_shop', 'restaurant'],
                'amenities' => ['parking', 'wifi', 'cart_rental'],
                'rating' => 4.6,
                'reviews_count' => 987,
                'status' => 'published',
                'is_featured' => false,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = GolfCourse::create($courseData);
            $this->createHolesForCourse($course);
        }

        $this->command->info('✓ Created ' . count($courses) . ' golf courses with holes');
    }

    protected function createHolesForCourse($course)
    {
        $parSequences = [
            18 => [4, 5, 4, 3, 4, 5, 3, 4, 4, 4, 4, 3, 5, 4, 4, 3, 4, 4], // Par 72
            17 => [4, 5, 4, 3, 4, 5, 3, 4, 4, 4, 4, 3, 5, 4, 4, 3, 4, 3], // Par 71
            16 => [4, 4, 4, 3, 4, 5, 3, 4, 4, 4, 4, 3, 5, 4, 4, 3, 4, 4], // Par 70
        ];

        $parValue = (int) $course->par;
        $pars = $parSequences[$parValue] ?? $parSequences[18];

        for ($i = 1; $i <= $course->holes_count; $i++) {
            $par = $pars[$i - 1];
            
            GolfHole::create([
                'golf_course_id' => $course->id,
                'hole_number' => $i,
                'name' => 'Hole ' . $i,
                'description' => $this->getHoleDescription($par, $i),
                'par' => $par,
                'yardage' => [
                    'championship' => $this->getYardage($par, 'championship'),
                    'regular' => $this->getYardage($par, 'regular'),
                    'forward' => $this->getYardage($par, 'forward'),
                ],
                'coordinates' => [
                    'x' => rand(10, 90),
                    'y' => rand(10, 90),
                ],
                'handicap' => $i,
                'hazards' => $this->getRandomHazards(),
                'tips' => $this->getHoleTips($par),
                'sort_order' => $i,
            ]);
        }
    }

    protected function getHoleDescription($par, $holeNumber)
    {
        $descriptions = [
            3 => "A challenging par-3 that demands precision with your tee shot. The green is well-protected by bunkers.",
            4 => "This par-4 requires strategic placement off the tee. A slight dogleg demands accuracy and course management.",
            5 => "A reachable par-5 for long hitters. Strategic decisions on whether to go for the green in two make this hole exciting.",
        ];

        return $descriptions[$par] ?? "Hole {$holeNumber} presents a fair test of golf.";
    }

    protected function getYardage($par, $teeType)
    {
        $ranges = [
            3 => ['championship' => [180, 220], 'regular' => [150, 180], 'forward' => [120, 150]],
            4 => ['championship' => [380, 450], 'regular' => [340, 400], 'forward' => [280, 340]],
            5 => ['championship' => [520, 590], 'regular' => [480, 540], 'forward' => [420, 480]],
        ];

        $range = $ranges[$par][$teeType];
        return rand($range[0], $range[1]);
    }

    protected function getRandomHazards()
    {
        $allHazards = ['bunker', 'water', 'trees', 'rough', 'out_of_bounds'];
        $count = rand(1, 3);
        return array_rand(array_flip($allHazards), $count);
    }

    protected function getHoleTips($par)
    {
        $tips = [
            3 => "Club selection is key. Don't be short - better to be long than in the bunker.",
            4 => "Favor the right side of the fairway for the best angle into the green.",
            5 => "Play smart. A well-placed layup often leads to better scoring opportunities.",
        ];

        return $tips[$par] ?? "Play to your strengths and stay patient.";
    }

    protected function createGolfTours()
    {
        $this->command->info('Creating golf tours...');

        $tours = [
            [
                'vendor_id' => 1,
                'name' => 'California Coastal Golf Experience',
                'slug' => 'california-coastal-golf-experience',
                'description' => 'Experience the best of California golf with rounds at Pebble Beach, Spyglass Hill, and other iconic coastal courses. Includes luxury accommodation and gourmet dining.',
                'itinerary' => "Day 1: Arrival and welcome dinner\nDay 2: Pebble Beach Golf Links\nDay 3: Spyglass Hill Golf Course\nDay 4: Spanish Bay Golf Links\nDay 5: Departure",
                'duration_days' => 5,
                'duration_nights' => 4,
                'rounds_of_golf' => 3,
                'price_from' => 4500,
                'min_participants' => 4,
                'max_participants' => 16,
                'inclusions' => ['Accommodation at The Inn at Spanish Bay', '3 rounds of golf', 'Daily breakfast', 'Welcome and farewell dinners', 'Golf cart and range balls', 'Professional golf guide'],
                'exclusions' => ['Airfare', 'Lunch and dinner (except specified)', 'Personal expenses', 'Gratuities', 'Travel insurance'],
                'difficulty_level' => 'intermediate',
                'status' => 'published',
                'is_featured' => true,
                'rating' => 4.8,
                'reviews_count' => 156,
                'available_from' => now(),
                'available_to' => now()->addYear(),
            ],
            [
                'vendor_id' => 3,
                'name' => 'Scottish Golf Heritage Tour',
                'slug' => 'scottish-golf-heritage-tour',
                'description' => 'Journey through Scotland\'s most historic golf courses including St Andrews Old Course, Royal Troon, and Carnoustie. Immerse yourself in golf history and Scottish culture.',
                'itinerary' => "Day 1: Arrival in Edinburgh\nDay 2: Old Course at St Andrews\nDay 3: Castle Course\nDay 4: Carnoustie Championship Course\nDay 5: Royal Troon\nDay 6: Turnberry\nDay 7: Departure",
                'duration_days' => 7,
                'duration_nights' => 6,
                'rounds_of_golf' => 5,
                'price_from' => 5800,
                'min_participants' => 6,
                'max_participants' => 12,
                'inclusions' => ['Luxury hotel accommodation', '5 championship rounds', 'Daily Scottish breakfast', 'Welcome whisky tasting', 'Golf transfers', 'Caddie services'],
                'exclusions' => ['International flights', 'Lunch and dinner', 'Alcoholic beverages', 'Personal expenses', 'Travel insurance'],
                'difficulty_level' => 'advanced',
                'status' => 'published',
                'is_featured' => true,
                'rating' => 4.9,
                'reviews_count' => 203,
                'available_from' => now(),
                'available_to' => now()->addYear(),
            ],
            [
                'vendor_id' => 2,
                'name' => 'Masters Week Experience',
                'slug' => 'masters-week-experience',
                'description' => 'Once-in-a-lifetime opportunity to attend The Masters Tournament and play Augusta National. Limited availability.',
                'itinerary' => "Day 1: Arrival and course tour\nDay 2: Practice round at Augusta National\nDay 3: Masters Tournament - Day 1\nDay 4: Masters Tournament - Day 2\nDay 5: Departure",
                'duration_days' => 5,
                'duration_nights' => 4,
                'rounds_of_golf' => 1,
                'price_from' => 15000,
                'min_participants' => 2,
                'max_participants' => 8,
                'inclusions' => ['Luxury accommodation', '1 round at Augusta National', 'Masters Tournament tickets (2 days)', 'VIP hospitality', 'Transportation', 'Commemorative gifts'],
                'exclusions' => ['Airfare', 'All meals', 'Personal expenses', 'Additional tournament tickets'],
                'difficulty_level' => 'all_levels',
                'status' => 'published',
                'is_featured' => true,
                'rating' => 5.0,
                'reviews_count' => 47,
                'available_from' => now()->addMonths(2),
                'available_to' => now()->addMonths(3),
            ],
        ];

        foreach ($tours as $tourData) {
            GolfTour::create($tourData);
        }

        $this->command->info('✓ Created ' . count($tours) . ' golf tours');
    }

    protected function createTeeTimes()
    {
        $this->command->info('Creating tee times...');

        $courses = GolfCourse::all();
        $count = 0;

        foreach ($courses as $course) {
            // Create tee times for next 30 days
            for ($day = 0; $day < 30; $day++) {
                $date = now()->addDays($day);
                
                // Morning times (7:00 AM - 12:00 PM)
                for ($hour = 7; $hour <= 12; $hour++) {
                    foreach ([0, 15, 30, 45] as $minute) {
                        TeeTime::create([
                            'golf_course_id' => $course->id,
                            'date' => $date->toDateString(),
                            'time' => sprintf('%02d:%02d:00', $hour, $minute),
                            'available_slots' => 4,
                            'booked_slots' => rand(0, 2), // Some already booked
                            'price' => $this->getTeeTimePrice($course, $date),
                            'weekend_price' => $this->getWeekendPrice($course, $date),
                            'is_available' => true,
                        ]);
                        $count++;
                    }
                }

                // Afternoon times (1:00 PM - 5:00 PM)
                for ($hour = 13; $hour <= 17; $hour++) {
                    foreach ([0, 15, 30, 45] as $minute) {
                        TeeTime::create([
                            'golf_course_id' => $course->id,
                            'date' => $date->toDateString(),
                            'time' => sprintf('%02d:%02d:00', $hour, $minute),
                            'available_slots' => 4,
                            'booked_slots' => rand(0, 1),
                            'price' => $this->getTeeTimePrice($course, $date),
                            'weekend_price' => $this->getWeekendPrice($course, $date),
                            'is_available' => true,
                        ]);
                        $count++;
                    }
                }
            }
        }

        $this->command->info('✓ Created ' . $count . ' tee times');
    }

    protected function getTeeTimePrice($course, $date)
    {
        $basePrices = [
            'championship' => 350,
            'resort' => 250,
            'private' => 400,
            'municipal' => 80,
        ];

        return $basePrices[$course->course_type] ?? 150;
    }

    protected function getWeekendPrice($course, $date)
    {
        $basePrice = $this->getTeeTimePrice($course, $date);
        return $basePrice * 1.3; // 30% markup for weekends
    }

    protected function createBookings()
    {
        $this->command->info('Creating demo bookings...');

        $customers = User::where('type', 'customer')->get();
        $teeTimes = TeeTime::where('booked_slots', '<', 4)
            ->where('date', '>=', today())
            ->inRandomOrder()
            ->take(50)
            ->get();

        $count = 0;
        foreach ($teeTimes as $teeTime) {
            $customer = $customers->random();
            $playersCount = rand(1, 4);
            
            $subtotal = $teeTime->getCurrentPrice() * $playersCount;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;

            $statuses = ['confirmed', 'confirmed', 'confirmed', 'pending', 'completed'];
            $status = $statuses[array_rand($statuses)];

            $booking = Booking::create([
                'booking_number' => 'BK-' . strtoupper(Str::random(10)),
                'user_id' => $customer->id,
                'golf_course_id' => $teeTime->golf_course_id,
                'tee_time_id' => $teeTime->id,
                'booking_date' => $teeTime->date,
                'booking_time' => $teeTime->time,
                'players_count' => $playersCount,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'currency' => 'usd',
                'status' => $status,
                'payment_status' => $status === 'confirmed' || $status === 'completed' ? 'paid' : 'pending',
                'payment_method' => 'Credit Card',
                'confirmed_at' => $status === 'confirmed' || $status === 'completed' ? now() : null,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Update tee time booked slots
            $teeTime->increment('booked_slots', $playersCount);
            $count++;
        }

        $this->command->info('✓ Created ' . $count . ' bookings');
    }
}