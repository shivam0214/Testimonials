# Testimonials Package

A comprehensive Laravel package for managing testimonials with advanced features including photos, ratings, locations, permissions management, API endpoints, and Blade views.

## Features

- ✨ **Rich Testimonial Data**: Names, photos, locations, ratings, company info, designations
- 📸 **Photo Uploads**: Store and manage testimonial photos
- ⭐ **Star Ratings**: 1-5 star rating system
- 🔒 **Permission Management**: Built-in Spatie Laravel Permission integration
- 🌐 **RESTful API**: Complete JSON API for testimonials
- 🎨 **Blade Views**: Pre-built views for displaying testimonials
- 📊 **Moderation**: Approve/reject testimonials workflow
- 🔍 **Search & Filter**: Filter by location, company, rating, status
- 👁️ **View Tracking**: Track number of views per testimonial
- 🗑️ **Soft Deletes**: Soft delete support
- 📱 **Responsive Design**: Mobile-friendly templates

## Installation

### 1. Install the Package

```bash
composer require samkumar/testimonials
```

### 2. Publish Configuration

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-config"
```

### 3. Publish Migrations

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-migrations"
```

### 4. Publish Views (Optional)

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-views"
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Permissions (Optional)

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"
```

### 7. Seed Dummy Data (Optional)

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsSeeder"
```

## Configuration

The package configuration file is located at `config/testimonials.php`. Key configuration options:

```php
return [
    'moderation_enabled' => true,           // Enable moderation
    'per_page' => 15,                       // Pagination per page
    'storage_path' => 'testimonials',       // Storage path for photos
    'max_photo_size' => 2,                  // Max photo size (MB)
    'enable_ratings' => true,               // Enable rating system
    'track_views' => true,                  // Track page views
    'soft_deletes' => true,                 // Enable soft deletes
];
```

## Database Schema

### Testimonials Table

```
id                    - bigint (primary key)
user_id              - bigint (nullable, foreign key)
name                 - string
email                - string
location             - string
message              - text
photo                - string (nullable)
rating               - integer (1-5)
status               - enum (pending, approved, rejected)
company_name         - string (nullable)
designation          - string (nullable)
website_url          - string (nullable)
social_links         - text (JSON)
views_count          - integer
soft deletes
timestamps
```

## Usage

### Web Routes

#### Display All Testimonials
```blade
GET /testimonials
```

#### View Single Testimonial
```blade
GET /testimonials/{id}
```

#### Create Testimonial (Form)
```blade
GET /testimonials/create
```

#### Submit Testimonial
```blade
POST /testimonials
```

#### Update Testimonial
```blade
PUT /testimonials/{id}
```

#### Delete Testimonial
```blade
DELETE /testimonials/{id}
```

#### Approve Testimonial (Admin)
```blade
POST /testimonials/{id}/approve
```

#### Reject Testimonial (Admin)
```blade
POST /testimonials/{id}/reject
```

### API Routes

All API routes are prefixed with `/api/testimonials`

#### List Testimonials
```bash
GET /api/testimonials
```

**Query Parameters:**
- `status` - Filter by status (pending, approved, rejected)
- `rating` - Filter by rating (1-5)
- `location` - Filter by location
- `company` - Filter by company
- `public` - Get only approved (boolean)
- `order_by` - Order by field (created_at, rating, etc.)
- `order_dir` - Order direction (asc, desc)
- `per_page` - Results per page

**Example:**
```bash
GET /api/testimonials?status=approved&rating=5&per_page=10
```

#### Get Single Testimonial
```bash
GET /api/testimonials/{id}
```

#### Get Statistics
```bash
GET /api/testimonials/statistics
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total": 20,
    "approved": 15,
    "pending": 3,
    "rejected": 2,
    "average_rating": 4.5,
    "total_views": 1250
  }
}
```

#### Get By Rating
```bash
GET /api/testimonials/rating/{rating}
```

#### Create Testimonial (Authenticated)
```bash
POST /api/testimonials
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "location": "New York, USA",
  "message": "This is a great service!",
  "rating": 5,
  "photo": "file",
  "company_name": "Tech Corp",
  "designation": "CEO",
  "website_url": "https://example.com",
  "social_links": {
    "twitter": "https://twitter.com/johndoe",
    "linkedin": "https://linkedin.com/in/johndoe"
  }
}
```

#### Update Testimonial (Authenticated)
```bash
POST /api/testimonials/{id}
Content-Type: application/json
```

#### Delete Testimonial (Authenticated)
```bash
DELETE /api/testimonials/{id}
```

#### Approve Testimonial (Admin)
```bash
POST /api/testimonials/{id}/approve
```

#### Reject Testimonial (Admin)
```bash
POST /api/testimonials/{id}/reject
```

## Blade Views

### Display All Testimonials
```blade
@include('testimonials::index', ['testimonials' => $testimonials])
```

### Display Single Testimonial
```blade
@include('testimonials::show', ['testimonial' => $testimonial])
```

### Display Form
```blade
@include('testimonials::create')
```

### Custom Usage

```blade
@foreach($testimonials as $testimonial)
    <div class="testimonial">
        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}">
        <h3>{{ $testimonial->name }}</h3>
        <p>{{ $testimonial->message }}</p>
        <p>Rating: {{ $testimonial->rating }}/5</p>
        <p>Location: {{ $testimonial->location }}</p>
    </div>
@endforeach
```

## Permissions

The package creates the following permissions:

- `view testimonials`
- `create testimonials`
- `update testimonials`
- `delete testimonials`
- `approve testimonials`
- `reject testimonials`

### Roles

**Admin Role:**
- All permissions

**Moderator Role:**
- view, approve, reject

**User Role:**
- view, create, update

### Assigning Permissions

```php
$user->assignRole('admin');
// or
$user->givePermissionTo('approve testimonials');
```

## Model Usage

### Basic Queries

```php
use samkumar\Testimonials\Models\Testimonial;

// Get all approved testimonials
$testimonials = Testimonial::approved()->get();

// Get pending testimonials
$pending = Testimonial::pending()->get();

// Get high-rated testimonials
$highRated = Testimonial::highRated(4)->get();

// Get testimonials by location
$byLocation = Testimonial::byLocation('New York')->get();

// Get testimonials by company
$byCompany = Testimonial::byCompany('Tech Corp')->get();

// Order by latest
$latest = Testimonial::latest()->get();

// Order by rating
$byRating = Testimonial::orderByRating('desc')->get();
```

### Increment Views

```php
$testimonial = Testimonial::find(1);
$testimonial->incrementViews();
```

### Get Average Rating

```php
$average = Testimonial::approved()->avg('rating');
```

## Factory Usage

### Create Single Testimonial

```php
$testimonial = Testimonial::factory()->create();
```

### Create with State

```php
// Create approved testimonial
$approved = Testimonial::factory()->approved()->create();

// Create pending testimonial
$pending = Testimonial::factory()->pending()->create();

// Create rejected testimonial
$rejected = Testimonial::factory()->rejected()->create();
```

### Create Multiple

```php
$testimonials = Testimonial::factory()->count(10)->create();
```

## Customization

### Override Views

Publish views and modify them as needed:

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-views"
```

Views will be published to `resources/views/vendor/testimonials/`

### Custom Model

Extend the model for additional functionality:

```php
namespace App\Models;

use samkumar\Testimonials\Models\Testimonial as BaseTestimonial;

class Testimonial extends BaseTestimonial
{
    // Add custom methods
}
```

### Custom Controller

Extend the controller for additional logic:

```php
namespace App\Http\Controllers;

use samkumar\Testimonials\Controllers\TestimonialController as BaseController;

class TestimonialController extends BaseController
{
    // Override methods
}
```

## Events (Future)

Currently, no events are fired. Custom events can be added in your extended controller.

## Testing

Run the seeder to generate dummy data:

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsSeeder"
```

## File Upload

Photos are stored in the `storage/app/public/testimonials/` directory. Make sure symbolic link exists:

```bash
php artisan storage:link
```

Access photos at: `storage/testimonials/filename`

## Troubleshooting

### Migrations not found

Make sure to publish migrations:
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-migrations"
```

### Views not found

Publish views or configure view namespace in service provider.

### Permission errors

Run the permission seeder:
```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"
```

## Support

For issues and questions, please create an issue on GitHub.

## License

The Testimonials Package is open-sourced software licensed under the MIT license.

## Author

Created with ❤️ by samkumar Islam
