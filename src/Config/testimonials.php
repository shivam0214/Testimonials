<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Testimonials Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains all the settings for the Testimonials package
    |
    */

    // Model class
    'model' => \samkumar\Testimonials\Models\Testimonial::class,

    // Table name
    'table' => 'testimonials',

    // Enable/disable testimonial moderation
    'moderation_enabled' => true,

    // Default pagination per page
    'per_page' => 15,

    // Storage disk for photo uploads
    'storage_disk' => 'public',

    // Storage path for photos
    'storage_path' => 'testimonials',

    // Maximum photo file size (in MB)
    'max_photo_size' => 2,

    // Allowed photo mime types
    'allowed_photo_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ],

    // Status options
    'statuses' => [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],

    // Enable ratings
    'enable_ratings' => true,

    // Minimum rating
    'min_rating' => 1,

    // Maximum rating
    'max_rating' => 5,

    // Enable location field
    'enable_location' => true,

    // Enable company field
    'enable_company' => true,

    // Enable designation field
    'enable_designation' => true,

    // Enable website URL field
    'enable_website_url' => true,

    // Enable social links field
    'enable_social_links' => true,

    // Social media platforms
    'social_platforms' => [
        'twitter',
        'linkedin',
        'facebook',
        'instagram',
        'youtube',
    ],

    // Views tracking enabled
    'track_views' => true,

    // Soft deletes enabled
    'soft_deletes' => true,
];
