<?php

namespace samkumar\Testimonials\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use samkumar\Testimonials\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating')) {
            $query->byRating($request->rating);
        }

        // Filter by location
        if ($request->has('location')) {
            $query->byLocation($request->location);
        }

        // Filter by company
        if ($request->has('company')) {
            $query->byCompany($request->company);
        }

        // Get only approved for public API
        if ($request->has('public') && $request->public) {
            $query->approved();
        }

        // Order by
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        // Pagination
        $testimonials = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $testimonials,
            'message' => 'Testimonials retrieved successfully'
        ]);
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'website_url' => 'nullable|url',
            'social_links' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('testimonials', 'public');
            $validated['photo'] = $path;
        }

        // Set initial status
        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->id();

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'success' => true,
            'data' => $testimonial,
            'message' => 'Testimonial created successfully'
        ], 201);
    }

    /**
     * Display the specified testimonial.
     */
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Increment views
        $testimonial->incrementViews();

        return response()->json([
            'success' => true,
            'data' => $testimonial,
            'message' => 'Testimonial retrieved successfully'
        ]);
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Authorization check
        if ($testimonial->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('update testimonials')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'location' => 'sometimes|string|max:255',
            'message' => 'sometimes|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'sometimes|integer|min:1|max:5',
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'website_url' => 'nullable|url',
            'social_links' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('testimonials', 'public');
            $validated['photo'] = $path;
        }

        $testimonial->update($validated);

        return response()->json([
            'success' => true,
            'data' => $testimonial,
            'message' => 'Testimonial updated successfully'
        ]);
    }

    /**
     * Delete the specified testimonial.
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Authorization check
        if ($testimonial->user_id !== auth()->id() && !auth()->user()->hasPermissionTo('delete testimonials')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }

    /**
     * Approve testimonial (admin only).
     */
    public function approve(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('approve testimonials')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'data' => $testimonial,
            'message' => 'Testimonial approved successfully'
        ]);
    }

    /**
     * Reject testimonial (admin only).
     */
    public function reject(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('approve testimonials')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'data' => $testimonial,
            'message' => 'Testimonial rejected successfully'
        ]);
    }

    /**
     * Get statistics about testimonials.
     */
    public function statistics()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => Testimonial::count(),
                'approved' => Testimonial::approved()->count(),
                'pending' => Testimonial::pending()->count(),
                'rejected' => Testimonial::rejected()->count(),
                'average_rating' => Testimonial::approved()->avg('rating'),
                'total_views' => Testimonial::sum('views_count'),
            ],
            'message' => 'Statistics retrieved successfully'
        ]);
    }

    /**
     * Get testimonials by rating.
     */
    public function byRating($rating)
    {
        $testimonials = Testimonial::approved()
            ->byRating($rating)
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $testimonials,
            'message' => 'Testimonials retrieved successfully'
        ]);
    }
}
