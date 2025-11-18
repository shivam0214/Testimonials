# API Documentation - Testimonials Package

## Base URL

```
http://localhost:8000/api/testimonials
```

## Authentication

Protected endpoints require `Sanctum` token authentication:

```
Authorization: Bearer {token}
```

## Endpoints

### 1. List All Testimonials

**GET** `/api/testimonials`

Get a paginated list of testimonials with optional filters.

#### Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `status` | string | Filter by status: `approved`, `pending`, `rejected` |
| `rating` | integer | Filter by rating: `1`, `2`, `3`, `4`, `5` |
| `location` | string | Filter by location (partial match) |
| `company` | string | Filter by company name (partial match) |
| `public` | boolean | Get only approved testimonials (true/false) |
| `order_by` | string | Order by field: `created_at`, `rating`, etc. |
| `order_dir` | string | Sort direction: `asc`, `desc` |
| `per_page` | integer | Results per page (default: 15) |
| `page` | integer | Page number for pagination |

#### Example Requests

```bash
# Get all testimonials
GET /api/testimonials

# Get approved testimonials only
GET /api/testimonials?status=approved

# Get 5-star testimonials
GET /api/testimonials?rating=5

# Get testimonials from New York
GET /api/testimonials?location=New%20York

# Get testimonials from Tech Corp
GET /api/testimonials?company=Tech%20Corp

# Get approved testimonials ordered by rating (descending)
GET /api/testimonials?public=true&order_by=rating&order_dir=desc

# Get 10 results per page, page 2
GET /api/testimonials?per_page=10&page=2

# Complex filter
GET /api/testimonials?status=approved&rating=5&company=Tech&per_page=20
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "user_id": null,
        "name": "John Doe",
        "email": "john@example.com",
        "location": "New York, USA",
        "message": "Excellent service! Highly recommended.",
        "photo": "testimonials/photo1.jpg",
        "rating": 5,
        "status": "approved",
        "company_name": "Tech Corp",
        "designation": "CEO",
        "website_url": "https://techcorp.com",
        "social_links": {
          "twitter": "https://twitter.com/johndoe",
          "linkedin": "https://linkedin.com/in/johndoe"
        },
        "views_count": 145,
        "created_at": "2024-11-18T10:30:00.000000Z",
        "updated_at": "2024-11-18T10:30:00.000000Z",
        "deleted_at": null,
        "photo_url": "http://localhost:8000/storage/testimonials/photo1.jpg",
        "full_info": "John Doe from New York, USA",
        "average_rating": 4.5
      }
    ],
    "first_page_url": "http://localhost:8000/api/testimonials?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http://localhost:8000/api/testimonials?page=3",
    "links": [],
    "next_page_url": "http://localhost:8000/api/testimonials?page=2",
    "path": "http://localhost:8000/api/testimonials",
    "per_page": 15,
    "prev_page_url": null,
    "to": 15,
    "total": 45
  },
  "message": "Testimonials retrieved successfully"
}
```

---

### 2. Get Single Testimonial

**GET** `/api/testimonials/{id}`

Retrieve a specific testimonial by ID. Automatically increments view count.

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `id` | integer | Testimonial ID |

#### Example Request

```bash
GET /api/testimonials/1
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "user_id": null,
    "name": "John Doe",
    "email": "john@example.com",
    "location": "New York, USA",
    "message": "Excellent service! Highly recommended.",
    "photo": "testimonials/photo1.jpg",
    "rating": 5,
    "status": "approved",
    "company_name": "Tech Corp",
    "designation": "CEO",
    "website_url": "https://techcorp.com",
    "social_links": {
      "twitter": "https://twitter.com/johndoe",
      "linkedin": "https://linkedin.com/in/johndoe"
    },
    "views_count": 146,
    "created_at": "2024-11-18T10:30:00.000000Z",
    "updated_at": "2024-11-18T10:30:00.000000Z",
    "deleted_at": null,
    "photo_url": "http://localhost:8000/storage/testimonials/photo1.jpg",
    "full_info": "John Doe from New York, USA",
    "average_rating": 4.5
  },
  "message": "Testimonial retrieved successfully"
}
```

#### Error Response (404)

```json
{
  "success": false,
  "message": "Testimonial not found"
}
```

---

### 3. Get Statistics

**GET** `/api/testimonials/statistics`

Get overall statistics about testimonials.

#### Example Request

```bash
GET /api/testimonials/statistics
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "total": 20,
    "approved": 15,
    "pending": 3,
    "rejected": 2,
    "average_rating": 4.6,
    "total_views": 2450
  },
  "message": "Statistics retrieved successfully"
}
```

---

### 4. Get Testimonials by Rating

**GET** `/api/testimonials/rating/{rating}`

Get paginated testimonials filtered by specific rating.

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `rating` | integer | Rating value (1-5) |

#### Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `per_page` | integer | Results per page (default: 15) |
| `page` | integer | Page number |

#### Example Requests

```bash
# Get 5-star testimonials
GET /api/testimonials/rating/5

# Get 4-star testimonials, page 2
GET /api/testimonials/rating/4?page=2&per_page=20
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "rating": 5,
        "status": "approved",
        ...
      }
    ],
    "total": 12,
    "per_page": 15,
    "last_page": 1
  },
  "message": "Testimonials retrieved successfully"
}
```

---

### 5. Create Testimonial

**POST** `/api/testimonials`

Submit a new testimonial. Requires authentication.

#### Headers

```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | Yes | Full name (max 255 chars) |
| `email` | string | Yes | Email address |
| `location` | string | Yes | Location (max 255 chars) |
| `message` | string | Yes | Testimonial message (min 10, max 5000 chars) |
| `rating` | integer | Yes | Rating 1-5 |
| `photo` | file | No | Photo (JPEG, PNG, GIF, WebP; max 2MB) |
| `company_name` | string | No | Company name (max 255 chars) |
| `designation` | string | No | Job title (max 255 chars) |
| `website_url` | string | No | Website URL |
| `social_links` | object | No | Social media links |
| `social_links.twitter` | string | No | Twitter URL |
| `social_links.linkedin` | string | No | LinkedIn URL |
| `social_links.facebook` | string | No | Facebook URL |
| `social_links.instagram` | string | No | Instagram URL |
| `social_links.youtube` | string | No | YouTube URL |

#### Example Request (cURL)

```bash
curl -X POST http://localhost:8000/api/testimonials \
  -H "Authorization: Bearer {token}" \
  -F "name=Jane Smith" \
  -F "email=jane@example.com" \
  -F "location=London, UK" \
  -F "message=Amazing experience working with this team" \
  -F "rating=5" \
  -F "photo=@/path/to/photo.jpg" \
  -F "company_name=Digital Solutions" \
  -F "designation=Manager" \
  -F "website_url=https://digitalsolutions.com" \
  -F "social_links[twitter]=https://twitter.com/jane" \
  -F "social_links[linkedin]=https://linkedin.com/in/jane"
```

#### Example Request (JSON)

```bash
curl -X POST http://localhost:8000/api/testimonials \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "location": "London, UK",
    "message": "Amazing experience working with this team",
    "rating": 5,
    "company_name": "Digital Solutions",
    "designation": "Manager",
    "website_url": "https://digitalsolutions.com",
    "social_links": {
      "twitter": "https://twitter.com/jane",
      "linkedin": "https://linkedin.com/in/jane"
    }
  }'
```

#### Success Response (201)

```json
{
  "success": true,
  "data": {
    "id": 21,
    "user_id": 1,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "location": "London, UK",
    "message": "Amazing experience working with this team",
    "photo": "testimonials/photo21.jpg",
    "rating": 5,
    "status": "pending",
    "company_name": "Digital Solutions",
    "designation": "Manager",
    "website_url": "https://digitalsolutions.com",
    "social_links": {
      "twitter": "https://twitter.com/jane",
      "linkedin": "https://linkedin.com/in/jane"
    },
    "views_count": 0,
    "created_at": "2024-11-18T15:45:00.000000Z",
    "updated_at": "2024-11-18T15:45:00.000000Z",
    "deleted_at": null
  },
  "message": "Testimonial created successfully"
}
```

#### Validation Error Response (422)

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "email": ["The email must be a valid email address."],
    "message": ["The message must be at least 10 characters."],
    "rating": ["The rating must be between 1 and 5."]
  }
}
```

---

### 6. Update Testimonial

**POST** `/api/testimonials/{id}`

Update an existing testimonial. Only owner or admin can update.

#### Headers

```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `id` | integer | Testimonial ID |

#### Request Body

(Same as Create, but all fields are optional using `sometimes` rule)

#### Example Request

```bash
curl -X POST http://localhost:8000/api/testimonials/21 \
  -H "Authorization: Bearer {token}" \
  -F "message=Updated message" \
  -F "rating=4"
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "id": 21,
    "message": "Updated message",
    "rating": 4,
    ...
  },
  "message": "Testimonial updated successfully"
}
```

#### Authorization Error (403)

```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

### 7. Delete Testimonial

**DELETE** `/api/testimonials/{id}`

Delete a testimonial (soft delete). Only owner or admin can delete.

#### Headers

```
Authorization: Bearer {token}
```

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `id` | integer | Testimonial ID |

#### Example Request

```bash
curl -X DELETE http://localhost:8000/api/testimonials/21 \
  -H "Authorization: Bearer {token}"
```

#### Success Response (200)

```json
{
  "success": true,
  "message": "Testimonial deleted successfully"
}
```

---

### 8. Approve Testimonial

**POST** `/api/testimonials/{id}/approve`

Approve a pending testimonial. Requires `approve testimonials` permission (admin/moderator).

#### Headers

```
Authorization: Bearer {token}
```

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `id` | integer | Testimonial ID |

#### Example Request

```bash
curl -X POST http://localhost:8000/api/testimonials/1/approve \
  -H "Authorization: Bearer {token}"
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "status": "approved",
    ...
  },
  "message": "Testimonial approved successfully"
}
```

#### Permission Error (403)

```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

### 9. Reject Testimonial

**POST** `/api/testimonials/{id}/reject`

Reject a testimonial. Requires `approve testimonials` permission (admin/moderator).

#### Headers

```
Authorization: Bearer {token}
```

#### URL Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `id` | integer | Testimonial ID |

#### Example Request

```bash
curl -X POST http://localhost:8000/api/testimonials/1/reject \
  -H "Authorization: Bearer {token}"
```

#### Success Response (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "status": "rejected",
    ...
  },
  "message": "Testimonial rejected successfully"
}
```

---

## HTTP Status Codes

| Code | Meaning |
|------|---------|
| `200` | OK - Request successful |
| `201` | Created - Resource created successfully |
| `400` | Bad Request - Invalid request |
| `403` | Forbidden - Insufficient permissions |
| `404` | Not Found - Resource not found |
| `422` | Unprocessable Entity - Validation failed |
| `500` | Internal Server Error |

## Error Handling

All error responses follow this format:

```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["Error message"]
  }
}
```

## Rate Limiting

No rate limiting is configured by default. Implement in your middleware as needed.

## Testing with Postman

1. Import the endpoints into Postman
2. Set `Authorization` header with Bearer token
3. Test with different query parameters
4. Check responses match documented formats

## Example Workflow

### 1. Get All Testimonials
```bash
GET /api/testimonials?status=approved&per_page=5
```

### 2. View Single Testimonial
```bash
GET /api/testimonials/1
```

### 3. Create New Testimonial
```bash
POST /api/testimonials
Authorization: Bearer {user_token}
Content-Type: multipart/form-data

name=Test User&email=test@example.com&location=City,Country&message=Great service!&rating=5
```

### 4. Admin Approval
```bash
POST /api/testimonials/{id}/approve
Authorization: Bearer {admin_token}
```

---

## Support

For issues or questions about the API, refer to the main README.md or contact support.
