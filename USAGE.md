# Usage Examples - Testimonials Package

## Table of Contents

1. [Basic Usage](#basic-usage)
2. [Blade Templates](#blade-templates)
3. [API Usage](#api-usage)
4. [Eloquent Queries](#eloquent-queries)
5. [Permissions & Authorization](#permissions--authorization)
6. [Advanced Scenarios](#advanced-scenarios)

## Basic Usage

### Display Testimonials on Homepage

```php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use samkumar\Testimonials\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest 6 approved testimonials
        $testimonials = Testimonial::approved()
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('testimonials'));
    }
}
```

```blade
<!-- resources/views/home.blade.php -->

<section class="testimonials-section">
    <h2>What Our Clients Say</h2>
    @include('testimonials::index', ['testimonials' => $testimonials])
</section>
```

### Show Testimonial Details

```php
// app/Http/Controllers/TestimonialDetailController.php

class TestimonialDetailController extends Controller
{
    public function show($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->incrementViews();
        
        return view('testimonial.detail', compact('testimonial'));
    }
}
```

```blade
<!-- resources/views/testimonial/detail.blade.php -->

@extends('layouts.app')

@section('content')
    @include('testimonials::show', ['testimonial' => $testimonial])
@endsection
```

## Blade Templates

### Display Testimonial Grid

```blade
<div class="testimonials-grid">
    @forelse($testimonials as $testimonial)
        <div class="testimonial-item">
            <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}">
            <h3>{{ $testimonial->name }}</h3>
            <p class="designation">{{ $testimonial->designation }}</p>
            <div class="rating">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $testimonial->rating ? 'filled' : '' }}">★</span>
                @endfor
            </div>
            <p class="message">{{ $testimonial->message }}</p>
            <a href="{{ route('testimonials.show', $testimonial->id) }}">Read More</a>
        </div>
    @empty
        <p>No testimonials available yet.</p>
    @endforelse
</div>
```

### Display Testimonial Carousel

```blade
<div class="carousel">
    @foreach($testimonials as $testimonial)
        <div class="carousel-item">
            <blockquote>
                "{{ $testimonial->message }}"
                <footer>
                    <strong>{{ $testimonial->name }}</strong> 
                    <span>{{ $testimonial->location }}</span>
                </footer>
            </blockquote>
        </div>
    @endforeach
</div>
```

### Display Single Card Component

```blade
@include('testimonials::components.card', ['testimonial' => $testimonial])
```

### Display Top Rated Testimonials

```blade
<div class="top-rated">
    <h2>Top Rated Testimonials</h2>
    @foreach($testimonials->sortByDesc('rating')->take(5) as $testimonial)
        <div class="testimonial-badge">
            <span class="rating-badge">{{ $testimonial->rating }} ⭐</span>
            <h4>{{ $testimonial->name }}</h4>
            <p>{{ Str::limit($testimonial->message, 100) }}</p>
        </div>
    @endforeach
</div>
```

### Create Testimonial Form

```blade
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Submit Your Testimonial</h1>
        @include('testimonials::create')
    </div>
@endsection
```

## API Usage

### cURL Examples

#### Get All Approved Testimonials

```bash
curl -X GET "http://localhost:8000/api/testimonials?status=approved&per_page=10" \
  -H "Accept: application/json"
```

#### Get 5-Star Testimonials

```bash
curl -X GET "http://localhost:8000/api/testimonials?rating=5&order_by=created_at&order_dir=desc" \
  -H "Accept: application/json"
```

#### Get Statistics

```bash
curl -X GET "http://localhost:8000/api/testimonials/statistics" \
  -H "Accept: application/json"
```

#### Create Testimonial with Authentication

```bash
curl -X POST "http://localhost:8000/api/testimonials" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Accept: application/json" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "location=New York, USA" \
  -F "message=Excellent service and great team!" \
  -F "rating=5" \
  -F "photo=@/path/to/photo.jpg" \
  -F "company_name=Tech Corp" \
  -F "designation=CEO"
```

#### Approve Testimonial (Admin)

```bash
curl -X POST "http://localhost:8000/api/testimonials/1/approve" \
  -H "Authorization: Bearer ADMIN_TOKEN" \
  -H "Accept: application/json"
```

### JavaScript/Fetch Examples

#### Get Testimonials

```javascript
fetch('/api/testimonials?status=approved&per_page=10')
  .then(response => response.json())
  .then(data => {
    console.log(data.data);
    // Display testimonials
  })
  .catch(error => console.error('Error:', error));
```

#### Submit Testimonial

```javascript
const formData = new FormData();
formData.append('name', 'John Doe');
formData.append('email', 'john@example.com');
formData.append('location', 'New York, USA');
formData.append('message', 'Great service!');
formData.append('rating', 5);
formData.append('photo', fileInput.files[0]);

fetch('/api/testimonials', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
  },
  body: formData
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    alert('Testimonial submitted successfully!');
  }
})
.catch(error => console.error('Error:', error));
```

#### Get Single Testimonial

```javascript
fetch('/api/testimonials/1')
  .then(response => response.json())
  .then(data => {
    const testimonial = data.data;
    document.querySelector('.testimonial-title').textContent = testimonial.name;
    document.querySelector('.testimonial-message').textContent = testimonial.message;
    document.querySelector('.testimonial-rating').textContent = testimonial.rating + '/5';
  });
```

### Axios Examples

#### Get Testimonials with Filtering

```javascript
import axios from 'axios';

axios.get('/api/testimonials', {
  params: {
    status: 'approved',
    rating: 5,
    per_page: 10,
    page: 1
  }
})
.then(response => {
  console.log(response.data.data);
})
.catch(error => console.error(error));
```

#### Create Testimonial

```javascript
const data = new FormData();
data.append('name', 'Jane Smith');
data.append('email', 'jane@example.com');
data.append('location', 'London, UK');
data.append('message', 'Excellent work!');
data.append('rating', 5);
data.append('photo', fileInput.files[0]);

axios.post('/api/testimonials', data, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'multipart/form-data'
  }
})
.then(response => {
  console.log('Testimonial created:', response.data);
})
.catch(error => console.error(error));
```

## Eloquent Queries

### Basic Queries

```php
use samkumar\Testimonials\Models\Testimonial;

// Get all testimonials
$all = Testimonial::all();

// Get approved testimonials
$approved = Testimonial::approved()->get();

// Get pending testimonials
$pending = Testimonial::pending()->get();

// Get with pagination
$paginated = Testimonial::paginate(15);

// Count testimonials
$count = Testimonial::count();
$approvedCount = Testimonial::approved()->count();
```

### Advanced Filtering

```php
// Get testimonials with multiple conditions
$testimonials = Testimonial::where('status', 'approved')
    ->where('rating', '>=', 4)
    ->where('location', 'like', '%New York%')
    ->get();

// Using scopes
$testimonials = Testimonial::approved()
    ->byLocation('New York')
    ->byCompany('Tech Corp')
    ->orderByRating('desc')
    ->get();

// High-rated testimonials
$topRated = Testimonial::highRated(4)->approved()->get();

// Order and limit
$latest = Testimonial::approved()
    ->latest()
    ->limit(5)
    ->get();
```

### Searching and Filtering

```php
// Search by name
$results = Testimonial::where('name', 'like', '%John%')->get();

// Search by location
$byLocation = Testimonial::byLocation('New York')->get();

// Search by company
$byCompany = Testimonial::byCompany('Tech')->get();

// Filter by rating
$fiveStars = Testimonial::byRating(5)->get();

// Get testimonials from specific user
$userTestimonials = Testimonial::where('user_id', auth()->id())->get();
```

### Calculations

```php
// Average rating
$avgRating = Testimonial::approved()->avg('rating');

// Count by status
$stats = [
    'approved' => Testimonial::approved()->count(),
    'pending' => Testimonial::pending()->count(),
    'rejected' => Testimonial::rejected()->count(),
];

// Total views
$totalViews = Testimonial::sum('views_count');

// Most viewed
$mostViewed = Testimonial::orderBy('views_count', 'desc')
    ->first();
```

### Relationships

```php
// Get testimonial with user
$testimonial = Testimonial::with('user')->find(1);

// Get user information
if ($testimonial->user) {
    echo $testimonial->user->name;
}

// Get testimonials for a specific user
$userTestimonials = Testimonial::where('user_id', 1)->get();
```

### Using Factories

```php
// Create a single testimonial
$testimonial = Testimonial::factory()->create();

// Create multiple
$testimonials = Testimonial::factory(10)->create();

// Create with state
$approved = Testimonial::factory()->approved()->create();
$pending = Testimonial::factory()->pending(5)->create();

// Create with custom data
$custom = Testimonial::factory()->create([
    'name' => 'Custom Name',
    'rating' => 5,
]);
```

## Permissions & Authorization

### Check Permissions

```php
// Check single permission
if (auth()->user()->hasPermissionTo('view testimonials')) {
    // User has permission
}

// Check multiple permissions
if (auth()->user()->hasAnyPermission(['create testimonials', 'update testimonials'])) {
    // User has at least one permission
}

// Check all permissions
if (auth()->user()->hasAllPermissions(['view', 'create', 'update'])) {
    // User has all permissions
}
```

### Check Roles

```php
// Check single role
if (auth()->user()->hasRole('admin')) {
    // User is admin
}

// Check multiple roles
if (auth()->user()->hasAnyRole(['admin', 'moderator'])) {
    // User has at least one role
}
```

### Assign Permissions and Roles

```php
$user = User::find(1);

// Assign role
$user->assignRole('admin');

// Give specific permission
$user->givePermissionTo('approve testimonials');

// Assign multiple
$user->assignRole(['admin', 'moderator']);
$user->givePermissionTo(['create testimonials', 'update testimonials']);
```

### Middleware Protection

```php
// In your routes
Route::post('/testimonials/{id}/approve', [TestimonialController::class, 'approve'])
    ->middleware('auth')
    ->middleware('role:admin');

// Or in controller
public function approve($id)
{
    if (!auth()->user()->hasPermissionTo('approve testimonials')) {
        abort(403, 'Unauthorized');
    }
    
    // Approve logic
}
```

## Advanced Scenarios

### Display Statistics Dashboard

```php
// app/Http/Controllers/DashboardController.php

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Testimonial::count(),
            'approved' => Testimonial::approved()->count(),
            'pending' => Testimonial::pending()->count(),
            'rejected' => Testimonial::rejected()->count(),
            'average_rating' => Testimonial::approved()->avg('rating'),
            'total_views' => Testimonial::sum('views_count'),
            'recent' => Testimonial::latest()->limit(10)->get(),
            'top_rated' => Testimonial::approved()
                ->orderByRating('desc')
                ->limit(5)
                ->get(),
        ];

        return view('dashboard', $stats);
    }
}
```

```blade
<!-- resources/views/dashboard.blade.php -->

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Testimonials</h3>
        <p class="stat-number">{{ $total }}</p>
    </div>
    <div class="stat-card">
        <h3>Approved</h3>
        <p class="stat-number">{{ $approved }}</p>
    </div>
    <div class="stat-card">
        <h3>Pending Review</h3>
        <p class="stat-number">{{ $pending }}</p>
    </div>
    <div class="stat-card">
        <h3>Average Rating</h3>
        <p class="stat-number">{{ number_format($average_rating, 1) }}/5</p>
    </div>
</div>

<section class="top-testimonials">
    <h2>Top Rated</h2>
    @foreach($top_rated as $testimonial)
        <div class="testimonial-preview">
            <h4>{{ $testimonial->name }}</h4>
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $testimonial->rating ? 'filled' : '' }}">★</span>
                @endfor
            </div>
            <p>{{ Str::limit($testimonial->message, 100) }}</p>
        </div>
    @endforeach
</section>
```

### Create Moderation Queue

```php
// app/Http/Controllers/Admin/ModerationController.php

class ModerationController extends Controller
{
    public function queue()
    {
        $pending = Testimonial::pending()
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return view('admin.testimonials.moderation', compact('pending'));
    }

    public function approve($id)
    {
        $this->authorize('approve', Testimonial::class);
        
        Testimonial::findOrFail($id)->update(['status' => 'approved']);
        
        return back()->with('success', 'Testimonial approved');
    }

    public function reject($id)
    {
        $this->authorize('approve', Testimonial::class);
        
        Testimonial::findOrFail($id)->update(['status' => 'rejected']);
        
        return back()->with('success', 'Testimonial rejected');
    }
}
```

### Export Testimonials to CSV

```php
// app/Http/Controllers/ExportController.php

use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportTestimonials()
    {
        $testimonials = Testimonial::approved()->get();
        
        return Excel::download(
            new TestimonialsExport($testimonials),
            'testimonials.xlsx'
        );
    }
}
```

### Send Notification on New Testimonial

```php
// app/Models/Testimonial.php - Observer pattern

class TestimonialObserver
{
    public function created(Testimonial $testimonial)
    {
        // Send notification to admins
        $admins = User::role('admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new NewTestimonialNotification($testimonial));
        }
    }
}
```

---

For more examples and advanced usage, refer to the main README.md and API.md files.
