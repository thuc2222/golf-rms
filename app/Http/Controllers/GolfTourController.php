<?php
// app/Http/Controllers/GolfTourController.php
namespace App\Http\Controllers;

use App\Models\GolfTour;
use Illuminate\Http\Request;

class GolfTourController extends Controller
{
    public function index(Request $request)
    {
        $query = GolfTour::published()->with('vendor');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        // Filter by duration
        if ($request->filled('duration')) {
            if ($request->duration === '1-3') {
                $query->whereBetween('duration_days', [1, 3]);
            } elseif ($request->duration === '4-7') {
                $query->whereBetween('duration_days', [4, 7]);
            } elseif ($request->duration === '8+') {
                $query->where('duration_days', '>=', 8);
            }
        }

        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price_from', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_from', '<=', $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        if ($sortBy === 'price') {
            $query->orderBy('price_from', 'asc');
        } elseif ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('name');
        }

        $tours = $query->paginate(12);

        return view('frontend.tours.index', compact('tours'));
    }

    public function show($slug)
    {
        $tour = GolfTour::with('vendor')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $tour->translate(app()->getLocale());

        $relatedTours = GolfTour::published()
            ->where('id', '!=', $tour->id)
            ->where('difficulty_level', $tour->difficulty_level)
            ->take(3)
            ->get();

        return view('frontend.tours.show', compact('tour', 'relatedTours'));
    }
}