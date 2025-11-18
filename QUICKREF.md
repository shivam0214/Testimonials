# Quick Reference Guide

## Installation Quick Start

```bash
# Install package
composer require samkumar/testimonials

# Publish assets
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider"

# Run migrations
php artisan migrate

# Seed permissions
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"

# (Optional) Seed dummy data
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsSeeder"
```

## Common Commands

```bash
# Clear cache after publishing
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Refresh migrations (development only)
php artisan migrate:refresh --seed

# Create storage link for photo uploads
php artisan storage:link
```

## Blade Includes

```blade
<!-- Display all testimonials (grid) -->
@include('testimonials::index', ['testimonials' => $testimonials])

<!-- Display single testimonial detail -->
@include('testimonials::show', ['testimonial' => $testimonial])

<!-- Display create form -->
@include('testimonials::create')

<!-- Display single card -->
@include('testimonials::components.card', ['testimonial' => $testimonial])
```

## Common Queries

```php
use samkumar\Testimonials\Models\Testimonial;

// Get approved testimonials
Testimonial::approved()->get();

// Get pending testimonials
Testimonial::pending()->get();

// Get by location
Testimonial::byLocation('New York')->get();

// Get by rating
Testimonial::byRating(5)->get();

// Get high-rated (4+ stars)
Testimonial::highRated(4)->get();

// Get latest
Testimonial::latest()->get();

// Get with pagination
Testimonial::paginate(15);

// Count by status
Testimonial::approved()->count();
Testimonial::pending()->count();
```

## API Quick Reference

```
GET    /api/testimonials                    - List all
GET    /api/testimonials/{id}               - Get one
POST   /api/testimonials                    - Create
POST   /api/testimonials/{id}               - Update
DELETE /api/testimonials/{id}               - Delete
POST   /api/testimonials/{id}/approve       - Approve
POST   /api/testimonials/{id}/reject        - Reject
GET    /api/testimonials/statistics         - Stats
GET    /api/testimonials/rating/{rating}    - By rating
```

## Web Routes Quick Reference

```
GET    /testimonials              - List all
GET    /testimonials/{id}         - View one
GET    /testimonials/create       - Create form
POST   /testimonials              - Store
PUT    /testimonials/{id}         - Update
DELETE /testimonials/{id}         - Delete
POST   /testimonials/{id}/approve - Approve
POST   /testimonials/{id}/reject  - Reject
```

## Permissions

- `view testimonials`
- `create testimonials`
- `update testimonials`
- `delete testimonials`
- `approve testimonials`
- `reject testimonials`

## Roles

- **Admin**: All permissions
- **Moderator**: view, approve, reject
- **User**: view, create, update

## Model Attributes

```
id                  - bigint (primary)
user_id             - bigint (nullable, foreign)
name                - string
email               - string
location            - string
message             - text
photo               - string (nullable)
rating              - integer (1-5)
status              - enum (pending, approved, rejected)
company_name        - string (nullable)
designation         - string (nullable)
website_url         - string (nullable)
social_links        - json (nullable)
views_count         - integer
created_at          - timestamp
updated_at          - timestamp
deleted_at          - timestamp (nullable)
```

## Useful Scopes

```php
// Status filters
->approved()
->pending()
->rejected()

// Content filters
->byLocation('City')
->byCompany('Company Name')
->byRating(5)
->highRated(4)

// Ordering
->latest()
->orderByRating('desc')

// Pagination
->paginate(15)
->simplePaginate(15)
```

## Authorization Checks

```php
// In controller
if (!auth()->user()->hasPermissionTo('approve testimonials')) {
    abort(403);
}

// In blade
@can('approve', \samkumar\Testimonials\Models\Testimonial::class)
    <!-- content -->
@endcan

// Check role
if (auth()->user()->hasRole('admin')) {
    // admin only
}
```

## Configuration Keys

```php
config('testimonials.moderation_enabled')    // true
config('testimonials.per_page')              // 15
config('testimonials.storage_path')          // 'testimonials'
config('testimonials.max_photo_size')        // 2 (MB)
config('testimonials.enable_ratings')        // true
config('testimonials.track_views')           // true
config('testimonials.soft_deletes')          // true
```

## Testing Queries

```php
// In tinker
Testimonial::count();
Testimonial::approved()->count();
Testimonial::avg('rating');
Testimonial::latest()->first();
Testimonial::factory()->create();
Testimonial::factory()->approved(10)->create();
```

## Useful Functions

```php
// On model instance
$testimonial->incrementViews();
$testimonial->getPhotoUrlAttribute();
$testimonial->getFullInfoAttribute();
$testimonial->getAverageRatingAttribute();

// Static queries
Testimonial::approved()->count();
Testimonial::sum('views_count');
Testimonial::avg('rating');
```

## URL Helpers

```php
// Generate URLs
route('testimonials.index')
route('testimonials.show', $testimonial->id)
route('testimonials.create')
route('testimonials.store')
route('testimonials.update', $testimonial->id)
route('testimonials.destroy', $testimonial->id)
route('testimonials.approve', $testimonial->id)
route('testimonials.reject', $testimonial->id)

// API URLs
route('api.testimonials.index')
route('api.testimonials.show', $testimonial->id)
route('api.testimonials.statistics')
route('api.testimonials.by-rating', 5)
```

## Error Handling

```php
// API responses
response()->json(['success' => true, 'data' => $testimonial], 200)
response()->json(['success' => false, 'message' => 'Error'], 400)
response()->json(['success' => false, 'message' => 'Unauthorized'], 403)
response()->json(['success' => false, 'message' => 'Not found'], 404)

// Exceptions
Testimonial::findOrFail($id)  // 404 if not found
abort(403)                     // 403 unauthorized
```

## File Locations

```
Config:      config/testimonials.php
Routes:      src/Routes/web.php, src/Routes/api.php
Models:      src/Models/Testimonial.php
Controllers: src/Controllers/TestimonialController.php
Views:       src/Views/*.blade.php
Migrations:  src/Database/Migrations/*.php
Seeders:     src/Database/Seeders/*.php
Factories:   src/Database/Factories/*.php
Requests:    src/Requests/*.php
```

## Storage

Photos are stored in:
```
storage/app/public/testimonials/
```

Accessible at:
```
/storage/testimonials/{filename}
```

## Environment Setup

```env
FILESYSTEM_DISK=public
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
```

## Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| Routes not found | `php artisan route:clear` |
| Views not found | Publish views with vendor:publish |
| Photos not showing | Run `php artisan storage:link` |
| Permissions not working | Run permission seeder |
| Migration errors | Check if migrations already exist |
| 403 errors | Check user permissions/roles |

## Performance Tips

```php
// Use eager loading
Testimonial::with('user')->get();

// Use pagination instead of get()
Testimonial::paginate(15);

// Cache frequently accessed data
Cache::remember('testimonials.approved', 3600, function() {
    return Testimonial::approved()->get();
});

// Use raw queries for complex operations
DB::table('testimonials')->where(...)->select(...)->get();
```

## Next Steps

1. Read INSTALLATION.md for detailed setup
2. Read README.md for complete documentation
3. Check API.md for API documentation
4. Review USAGE.md for examples
5. Test with provided seeders
6. Integrate into your application

---

For full documentation, see README.md, INSTALLATION.md, API.md, and USAGE.md files.
