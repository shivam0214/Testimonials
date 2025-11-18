# Installation Guide - Testimonials Package

## Prerequisites

- PHP >= 8.1
- Laravel >= 10.0
- Composer
- MySQL or PostgreSQL

## Step-by-Step Installation

### Step 1: Install the Package

```bash
composer require samkumar/testimonials
```

### Step 2: Install Spatie Permissions

If not already installed:

```bash
composer require spatie/laravel-permission
```

Then publish and run its migrations:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### Step 3: Publish Package Assets

#### Publish Configuration File
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-config"
```

This creates `config/testimonials.php`

#### Publish Migrations
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-migrations"
```

This copies migrations to `database/migrations/`

#### Publish Views (Optional)
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-views"
```

This copies views to `resources/views/vendor/testimonials/`

### Step 4: Run Migrations

```bash
php artisan migrate
```

This creates:
- `spatie_roles` table
- `spatie_permissions` table
- `spatie_role_has_permissions` table
- `spatie_model_has_permissions` table
- `spatie_model_has_roles` table
- `testimonials` table

### Step 5: Create Storage Link

Make uploaded photos accessible:

```bash
php artisan storage:link
```

### Step 6: Seed Permissions (Recommended)

Run the permissions seeder to create default roles and permissions:

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"
```

This creates:
- **Permissions**: view, create, update, delete, approve, reject testimonials
- **Roles**: admin, moderator, user
- **Role Permissions**: Assigns permissions to each role

### Step 7: Seed Dummy Data (Optional)

For testing purposes, seed dummy testimonial data:

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsSeeder"
```

This creates:
- 8 approved testimonials
- 5 pending testimonials
- 2 rejected testimonials
- 5 high-rated (5-star) testimonials

## Configuration

### Update User Model

Add the `HasRoles` trait to your User model:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    // ... rest of your model
}
```

### Assign Roles to Users

```php
use App\Models\User;

$user = User::find(1);

// Assign role
$user->assignRole('admin');

// Or assign multiple roles
$user->assignRole(['admin', 'moderator']);

// Assign permission directly
$user->givePermissionTo('approve testimonials');
```

### Environment Configuration

Update `.env` if needed:

```env
APP_NAME="Your App"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

## Verification

### Check Installation

```bash
# Check if testimonials table exists
php artisan tinker
>>> Schema::hasTable('testimonials')
true
```

### Test API

```bash
# Get all testimonials
curl http://localhost:8000/api/testimonials

# Get statistics
curl http://localhost:8000/api/testimonials/statistics

# View web testimonials
curl http://localhost:8000/testimonials
```

## Troubleshooting

### Issue: Migration file not found

**Solution**: Make sure you published migrations:
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-migrations"
```

### Issue: Spatie permissions not working

**Solution**: Make sure you ran:
```bash
php artisan migrate
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"
```

### Issue: Photo upload not working

**Solution**: Ensure storage link exists:
```bash
php artisan storage:link
```

And `storage/app/public` is writable:
```bash
chmod -R 775 storage/app/public
```

### Issue: Routes not working

**Solution**: Clear route cache:
```bash
php artisan route:clear
php artisan config:clear
```

### Issue: Views not found

**Solution**: Publish views:
```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-views"
```

## Next Steps

1. Create an admin user and assign `admin` role
2. Configure your app's authentication
3. Customize views in `resources/views/vendor/testimonials/`
4. Update `config/testimonials.php` with your preferences
5. Test API endpoints with Postman or similar tool
6. Integrate testimonials into your website

## Quick Start

### Display Testimonials on Homepage

```blade
<!-- resources/views/home.blade.php -->

<section class="testimonials">
    <h2>What Our Clients Say</h2>
    @include('testimonials::index', ['testimonials' => $testimonials])
</section>
```

In your controller:

```php
<?php

namespace App\Http\Controllers;

use samkumar\Testimonials\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::approved()
            ->orderByRating('desc')
            ->limit(6)
            ->get();

        return view('home', ['testimonials' => $testimonials]);
    }
}
```

### Create Testimonial Form

```blade
@extends('layouts.app')

@section('content')
    @include('testimonials::create')
@endsection
```

In your routes:

```php
Route::get('/testimonials/create', 'TestimonialController@create')->name('testimonials.create');
Route::post('/testimonials', 'TestimonialController@store')->name('testimonials.store');
```

## Support & Documentation

- Full documentation: See README.md
- API documentation: See README.md API Routes section
- Database schema: See README.md Database Schema section

## License

MIT License - See LICENSE file for details
