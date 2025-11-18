# Testimonials Package - Complete Setup Guide

## 🎉 Welcome!

You now have a **complete, production-ready Laravel Testimonials Package** with all advanced features. This guide will help you get started.

## 📦 What You Got

A fully-featured Laravel package that includes:

- ✅ **Advanced Features**: Photos, ratings, locations, company info, social links
- ✅ **RESTful API**: 9 complete endpoints with filtering and pagination
- ✅ **Blade Views**: 4 beautiful, responsive templates ready to use
- ✅ **Permission System**: Spatie Laravel Permission integration with roles
- ✅ **Database**: Migration with all necessary fields
- ✅ **Seeders**: Permission seeder and dummy data seeder
- ✅ **Factory**: Complete factory for testing
- ✅ **Documentation**: Comprehensive guides and examples

## 🚀 Quick Start (5 Minutes)

### Step 1: Add to Your Laravel Project

```bash
# In your Laravel project directory
composer require samkumar/testimonials
```

### Step 2: Publish Package Files

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider"
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

### Step 4: Set Up Permissions

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsPermissionSeeder"
```

### Step 5: (Optional) Seed Test Data

```bash
php artisan db:seed --class="samkumar\Testimonials\Database\Seeders\TestimonialsSeeder"
```

**Done! The package is ready to use.** ✅

## 📚 Documentation Files

| File | Purpose |
|------|---------|
| `README.md` | Full documentation, features, routes, API |
| `INSTALLATION.md` | Detailed installation with troubleshooting |
| `API.md` | Complete API documentation with examples |
| `USAGE.md` | Real-world usage examples and scenarios |
| `QUICKREF.md` | Quick reference for commands and queries |
| `CHANGELOG.md` | Version history and planned features |
| `STRUCTURE.md` | Complete file structure and summary |
| `LICENSE` | MIT License |

## 🎯 Start Using Immediately

### Display Testimonials in Your Blade

```blade
@extends('layouts.app')

@section('content')
    <section class="testimonials">
        <h2>What Our Clients Say</h2>
        @include('testimonials::index', ['testimonials' => $testimonials])
    </section>
@endsection
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

        return view('home', compact('testimonials'));
    }
}
```

### Call the API

```bash
# Get approved testimonials
curl http://localhost:8000/api/testimonials?status=approved&per_page=10

# Get statistics
curl http://localhost:8000/api/testimonials/statistics
```

## 🔐 User Roles & Permissions

### Automatic Roles Created

1. **Admin** - Full access to everything
2. **Moderator** - Can view, approve, and reject
3. **User** - Can view, create, and update their own

### Assign Roles

```php
$user->assignRole('admin');
// or
$user->assignRole(['admin', 'moderator']);
```

## 📋 Database Schema

The package creates a `testimonials` table with:

- **id** - Primary key
- **user_id** - Link to users (nullable)
- **name** - Full name
- **email** - Email address
- **location** - City/Country
- **message** - Testimonial text
- **photo** - Photo filename
- **rating** - 1-5 stars
- **status** - pending/approved/rejected
- **company_name** - Company name
- **designation** - Job title
- **website_url** - Website link
- **social_links** - JSON social media links
- **views_count** - View counter
- **timestamps** - created_at, updated_at
- **deleted_at** - Soft deletes

## 🔗 Routes Overview

### Web Routes

```
GET    /testimonials              Display all testimonials
GET    /testimonials/{id}         View single testimonial
GET    /testimonials/create       Show form
POST   /testimonials              Submit testimonial
PUT    /testimonials/{id}         Update testimonial
DELETE /testimonials/{id}         Delete testimonial
POST   /testimonials/{id}/approve Approve (admin only)
POST   /testimonials/{id}/reject  Reject (admin only)
```

### API Routes

```
GET    /api/testimonials                 List testimonials
GET    /api/testimonials/{id}            Get single
POST   /api/testimonials                 Create
POST   /api/testimonials/{id}            Update
DELETE /api/testimonials/{id}            Delete
POST   /api/testimonials/{id}/approve    Approve
POST   /api/testimonials/{id}/reject     Reject
GET    /api/testimonials/statistics      Statistics
GET    /api/testimonials/rating/{rating} By rating
```

## 💡 Common Tasks

### Get All Approved Testimonials

```php
$testimonials = Testimonial::approved()->get();
```

### Get Top-Rated Testimonials

```php
$topRated = Testimonial::approved()
    ->orderByRating('desc')
    ->limit(5)
    ->get();
```

### Search by Location

```php
$nyTestimonials = Testimonial::approved()
    ->byLocation('New York')
    ->get();
```

### Get Statistics

```php
$stats = [
    'total' => Testimonial::count(),
    'approved' => Testimonial::approved()->count(),
    'average_rating' => Testimonial::approved()->avg('rating'),
    'total_views' => Testimonial::sum('views_count'),
];
```

### Create a Testimonial (API)

```bash
curl -X POST http://localhost:8000/api/testimonials \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "location=New York, USA" \
  -F "message=Great service!" \
  -F "rating=5" \
  -F "photo=@/path/to/photo.jpg"
```

## 🎨 Customize Views

Views are in `resources/views/vendor/testimonials/`:

- `index.blade.php` - Grid of testimonials
- `show.blade.php` - Single testimonial detail
- `create.blade.php` - Testimonial form
- `components/card.blade.php` - Card component

Edit them to match your brand!

## ⚙️ Configuration

Configuration file: `config/testimonials.php`

Key settings:

```php
'moderation_enabled' => true,      // Enable/disable moderation
'per_page' => 15,                  // Pagination size
'max_photo_size' => 2,             // Max file size in MB
'enable_ratings' => true,          // Enable rating system
'track_views' => true,             // Track views
'soft_deletes' => true,            // Soft delete support
```

## 🐛 Troubleshooting

### Routes Not Found?

```bash
php artisan route:clear
php artisan config:clear
```

### Views Not Working?

```bash
php artisan vendor:publish --provider="samkumar\Testimonials\TestimonialsServiceProvider" --tag="testimonials-views"
```

### Photos Not Uploading?

```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### Permissions Not Working?

Make sure your User model has the `HasRoles` trait:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

## 📖 Next Steps

1. **Read** `README.md` for complete documentation
2. **Check** `API.md` for API details
3. **Review** `USAGE.md` for code examples
4. **Use** `QUICKREF.md` as a reference
5. **Customize** views for your brand
6. **Deploy** with confidence

## 🎓 Learning Path

### Beginner
1. Install the package
2. Seed dummy data
3. Display testimonials on homepage
4. Test in browser

### Intermediate
1. Create testimonial form
2. Add to your website
3. Customize views
4. Set up user roles

### Advanced
1. Use the API
2. Create admin dashboard
3. Implement moderation queue
4. Add custom features

## 📞 Support

- 📖 Full docs in `README.md`
- 🔗 API docs in `API.md`
- 💻 Examples in `USAGE.md`
- ⚡ Quick ref in `QUICKREF.md`

## 🚢 Ready to Deploy?

```bash
# Make sure everything is ready
php artisan migrate              # Migrations run
php artisan storage:link         # Photos accessible
php artisan db:seed              # Data seeded
php artisan cache:clear          # Cache cleared
```

## 🎁 Package Includes

- ✅ 1 Model with 10+ scopes
- ✅ 1 API Controller with 9 endpoints
- ✅ 1 Database Migration
- ✅ 2 Seeders (permissions + data)
- ✅ 1 Factory
- ✅ 4 Blade Views
- ✅ 2 Route Files (web + API)
- ✅ 2 Form Request Classes
- ✅ 1 Service Provider
- ✅ 1 Config File
- ✅ 8 Documentation Files
- ✅ Complete Spatie Permission Integration

**Total: 20+ Files, 3000+ Lines of Code**

## 🎯 Success Criteria

After installation, you should be able to:

- ✅ View testimonials at `/testimonials`
- ✅ Call API at `/api/testimonials`
- ✅ Create testimonials via form
- ✅ See permissions in database
- ✅ View seeded data
- ✅ Upload photos
- ✅ Use all Blade templates
- ✅ Filter and search testimonials

## 🚀 You're All Set!

The package is **production-ready** and includes:

- Complete database schema
- RESTful API
- Beautiful views
- Permission system
- Full documentation
- Code examples
- Seeders and factories

**Start building amazing testimonial features! 🎉**

---

### Quick Links

- **Main Docs**: `README.md`
- **Installation**: `INSTALLATION.md`
- **API Docs**: `API.md`
- **Examples**: `USAGE.md`
- **Quick Ref**: `QUICKREF.md`
- **Structure**: `STRUCTURE.md`
- **Version**: `CHANGELOG.md`

---

**Made with ❤️ for Laravel Developers**

Version 1.0.0 | MIT License
