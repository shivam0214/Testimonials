# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial package development

## [1.0.0] - 2024-11-18

### Added
- Initial release of Testimonials Package
- Complete CRUD operations for testimonials
- RESTful API endpoints
- Blade view templates
- Photo upload functionality
- Star rating system (1-5)
- Location tracking
- Company and designation fields
- Social media links support
- Spatie Laravel Permission integration
- Role-based access control (Admin, Moderator, User)
- Testimonial moderation workflow (Pending, Approved, Rejected)
- View count tracking
- Soft deletes support
- Advanced filtering and sorting
- Factory and seeder for dummy data
- Comprehensive documentation
- API documentation
- Installation guide

### Features
- **Models**: Testimonial model with relationships and scopes
- **Controllers**: RESTful API controller with complete CRUD
- **Migrations**: Database migration for testimonials table
- **Views**: Blade templates for listing, showing, and creating testimonials
- **Routes**: Web and API routes with authentication middleware
- **Permissions**: Spatie permission seeder for role-based access
- **Seeders**: TestimonialsSeeder for dummy data
- **Factories**: TestimonialFactory for creating test data
- **Configuration**: Customizable config file

### Database Fields
- id (Primary Key)
- user_id (Foreign Key - nullable)
- name
- email
- location
- message
- photo
- rating (1-5)
- status (pending/approved/rejected)
- company_name
- designation
- website_url
- social_links (JSON)
- views_count
- timestamps (created_at, updated_at)
- deleted_at (soft deletes)

### API Endpoints
- `GET /api/testimonials` - List testimonials
- `GET /api/testimonials/{id}` - Get single testimonial
- `GET /api/testimonials/statistics` - Get statistics
- `GET /api/testimonials/rating/{rating}` - Get by rating
- `POST /api/testimonials` - Create testimonial (authenticated)
- `POST /api/testimonials/{id}` - Update testimonial (authenticated)
- `DELETE /api/testimonials/{id}` - Delete testimonial (authenticated)
- `POST /api/testimonials/{id}/approve` - Approve (admin/moderator)
- `POST /api/testimonials/{id}/reject` - Reject (admin/moderator)

### Web Routes
- `GET /testimonials` - List testimonials
- `GET /testimonials/{id}` - View testimonial
- `GET /testimonials/create` - Create form
- `POST /testimonials` - Store testimonial (authenticated)
- `PUT /testimonials/{id}` - Update testimonial (authenticated)
- `DELETE /testimonials/{id}` - Delete testimonial (authenticated)
- `POST /testimonials/{id}/approve` - Approve (admin)
- `POST /testimonials/{id}/reject` - Reject (admin)

### Scopes
- `approved()` - Get approved testimonials
- `pending()` - Get pending testimonials
- `rejected()` - Get rejected testimonials
- `byRating($rating)` - Filter by rating
- `byLocation($location)` - Filter by location
- `byCompany($company)` - Filter by company
- `highRated($rating)` - Get high-rated testimonials
- `latest()` - Order by latest
- `orderByRating($order)` - Order by rating

### Permissions
- view testimonials
- create testimonials
- update testimonials
- delete testimonials
- approve testimonials
- reject testimonials

### Roles
- **Admin**: All permissions
- **Moderator**: View, approve, reject
- **User**: View, create, update

## Future Releases

### [1.1.0] - Planned
- Event system for testimonial actions
- Email notifications for moderation
- Advanced search functionality
- CSV export for testimonials
- Multiple photo uploads
- Response system for testimonials
- Like/thumbs up system
- Category support

### [1.2.0] - Planned
- Testing suite
- GraphQL API support
- Multi-language support
- Custom fields support
- Webhook integrations

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For support, please create an issue on GitHub or contact the maintainer.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## Version History

**v1.0.0** - Initial Release (Nov 18, 2024)
