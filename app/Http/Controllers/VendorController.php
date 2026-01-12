<?php
// app/Http/Controllers/VendorController.php
namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::where('status', 'approved')->with('user');

        if ($request->filled('search')) {
            $query->where('business_name', 'like', "%{$request->search}%");
        }

        $vendors = $query->paginate(12);

        return view('frontend.vendors.index', compact('vendors'));
    }

    public function show($slug)
    {
        $vendor = Vendor::with(['user', 'golfCourses' => function ($query) {
            $query->where('status', 'published');
        }, 'golfTours' => function ($query) {
            $query->where('status', 'published');
        }])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        return view('frontend.vendors.show', compact('vendor'));
    }
}