<?php
// app/Http/Controllers/GolfCourseController.php
namespace App\Http\Controllers;

use App\Models\GolfCourse;
use Illuminate\Http\Request;

class GolfCourseController extends Controller
{
    public function index(Request $request)
    {
        $query = GolfCourse::published()->with('vendor');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->whereJsonContains('address->city', $request->location);
        }

        // Filter by course type
        if ($request->filled('type')) {
            $query->where('course_type', $request->type);
        }

        // Filter by holes count
        if ($request->filled('holes')) {
            $query->where('holes_count', $request->holes);
        }

        // Filter by facilities
        if ($request->filled('facilities')) {
            foreach ($request->facilities as $facility) {
                $query->whereJsonContains('facilities', $facility);
            }
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        if ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'price') {
            $query->orderBy('price', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $courses = $query->paginate(12);

        $courseTypes = GolfCourse::published()
            ->distinct()
            ->pluck('course_type')
            ->filter();

        return view('frontend.courses.index', compact('courses', 'courseTypes'));
    }

    public function show($slug)
    {
        $course = GolfCourse::with(['vendor', 'holes'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $course->translate(app()->getLocale());

        $similarCourses = GolfCourse::published()
            ->where('id', '!=', $course->id)
            ->where('course_type', $course->course_type)
            ->take(3)
            ->get();

        return view('frontend.courses.show', compact('course', 'similarCourses'));
    }

    public function holes($slug)
    {
        $course = GolfCourse::with(['holes' => function ($query) {
            $query->orderBy('hole_number');
        }])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.courses.holes', compact('course'));
    }
}