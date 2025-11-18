<?php

namespace samkumar\Testimonials\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'company_name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'social_links' => 'nullable|array',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.facebook' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.youtube' => 'nullable|url',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your name.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'location.required' => 'Please provide your location.',
            'message.required' => 'Please provide your testimonial message.',
            'message.min' => 'Your testimonial must be at least 10 characters long.',
            'rating.required' => 'Please provide a rating.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
            'photo.image' => 'The photo must be an image file.',
            'photo.mimes' => 'The photo must be a JPEG, PNG, GIF, or WebP image.',
            'photo.max' => 'The photo may not be greater than 2MB.',
            'website_url.url' => 'Please provide a valid website URL.',
        ];
    }
}
