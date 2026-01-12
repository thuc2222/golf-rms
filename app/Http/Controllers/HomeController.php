<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\GolfCourse;
use App\Models\GolfTour;
use App\Models\Vendor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = GolfCourse::published()
            ->featured()
            ->with('vendor')
            ->take(6)
            ->get();

        $featuredTours = GolfTour::published()
            ->featured()
            ->with('vendor')
            ->take(4)
            ->get();

        $stats = [
            'total_courses' => GolfCourse::published()->count(),
            'total_tours' => GolfTour::published()->count(),
            'total_vendors' => Vendor::where('status', 'approved')->count(),
        ];

        return view('frontend.home', compact('featuredCourses', 'featuredTours', 'stats'));
    }
}