<div class="testimonial-form-container">
    <div class="form-wrapper">
        <h1>Submit Your Testimonial</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" class="testimonial-form">
            @csrf

            <div class="form-section">
                <h2>Personal Information</h2>

                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" placeholder="City, Country" value="{{ old('location') }}" required>
                    @error('location')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="photo">Profile Photo (Optional)</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <small>Max 2MB. Supported formats: JPEG, PNG, GIF</small>
                    @error('photo')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Professional Information</h2>

                <div class="form-group">
                    <label for="company_name">Company Name (Optional)</label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
                    @error('company_name')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="designation">Designation (Optional)</label>
                    <input type="text" id="designation" name="designation" placeholder="CEO, Manager, etc." value="{{ old('designation') }}">
                    @error('designation')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="website_url">Website URL (Optional)</label>
                    <input type="url" id="website_url" name="website_url" value="{{ old('website_url') }}">
                    @error('website_url')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Your Testimonial</h2>

                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                    <small>Minimum 10 characters</small>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Rating *</label>
                    <div class="rating-input">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }} required>
                            <label for="rating{{ $i }}" class="rating-label">
                                <span class="star">★</span>
                            </label>
                        @endfor
                    </div>
                    @error('rating')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Social Links (Optional)</h2>
                <div class="form-group">
                    <label for="social_twitter">Twitter</label>
                    <input type="url" id="social_twitter" name="social_links[twitter]" value="{{ old('social_links.twitter') }}">
                </div>

                <div class="form-group">
                    <label for="social_linkedin">LinkedIn</label>
                    <input type="url" id="social_linkedin" name="social_links[linkedin]" value="{{ old('social_links.linkedin') }}">
                </div>

                <div class="form-group">
                    <label for="social_facebook">Facebook</label>
                    <input type="url" id="social_facebook" name="social_links[facebook]" value="{{ old('social_links.facebook') }}">
                </div>

                <div class="form-group">
                    <label for="social_instagram">Instagram</label>
                    <input type="url" id="social_instagram" name="social_links[instagram]" value="{{ old('social_links.instagram') }}">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<style>
    .testimonial-form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 20px;
    }

    .form-wrapper {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-wrapper h1 {
        margin-top: 0;
        margin-bottom: 30px;
        font-size: 28px;
        color: #333;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h2 {
        margin: 0 0 20px 0;
        font-size: 18px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="url"],
    .form-group input[type="file"],
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        line-height: 1.5;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="url"]:focus,
    .form-group input[type="file"]:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        color: #999;
    }

    .rating-input {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .rating-input input[type="radio"] {
        display: none;
    }

    .rating-label {
        cursor: pointer;
        font-size: 28px;
        color: #ddd;
        transition: color 0.3s;
    }

    .rating-input input[type="radio"]:checked ~ .rating-label,
    .rating-label:hover {
        color: #ffc107;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert li {
        margin-bottom: 4px;
    }

    .error {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 20px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }
</style>
