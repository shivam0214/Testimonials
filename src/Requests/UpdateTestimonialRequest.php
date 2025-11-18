<?php

namespace samkumar\Testimonials\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'location' => 'sometimes|string|max:255',
            'message' => 'sometimes|string|min:10|max:5000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'sometimes|integer|min:1|max:5',
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
}
