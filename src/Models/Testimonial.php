<?php

namespace samkumar\Testimonials\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'testimonials';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'location',
        'message',
        'photo',
        'rating',
        'status',
        'company_name',
        'designation',
        'website_url',
        'social_links',
        'views_count',
    ];

    protected $casts = [
        'social_links' => 'array',
        'rating' => 'integer',
        'views_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'full_info',
        'average_rating',
    ];

    /**
     * Get the user that owns the testimonial.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Scope to get approved testimonials.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get pending testimonials.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get rejected testimonials.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope to filter by rating.
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope to filter by location.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    /**
     * Scope to filter by company.
     */
    public function scopeByCompany($query, $company)
    {
        return $query->where('company_name', 'like', "%{$company}%");
    }

    /**
     * Scope to get high rated testimonials.
     */
    public function scopeHighRated($query, $rating = 4)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Scope to order by latest.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope to order by rating.
     */
    public function scopeOrderByRating($query, $order = 'desc')
    {
        return $query->orderBy('rating', $order);
    }

    /**
     * Increment views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
        return $this;
    }

    /**
     * Get full information about testimonial.
     */
    public function getFullInfoAttribute()
    {
        return "{$this->name} from {$this->location}";
    }

    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return self::approved()->avg('rating');
    }

    /**
     * Get photo URL.
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }
}
