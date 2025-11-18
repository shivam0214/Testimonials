<div class="testimonial-show-container">
    <div class="testimonial-detail">
        <div class="testimonial-detail-header">
            <div class="detail-avatar">
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="avatar-img">
            </div>
            <div class="detail-info">
                <h1>{{ $testimonial->name }}</h1>
                @if($testimonial->designation)
                    <p class="designation">{{ $testimonial->designation }}</p>
                @endif
                @if($testimonial->company_name)
                    <p class="company">{{ $testimonial->company_name }}</p>
                @endif
                <p class="location">📍 {{ $testimonial->location }}</p>
            </div>
        </div>

        <div class="rating-section">
            <div class="stars-large">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $testimonial->rating ? 'filled' : 'empty' }}">★</span>
                @endfor
            </div>
            <span class="rating-number">{{ $testimonial->rating }}.0 out of 5</span>
        </div>

        <div class="message-section">
            <h2>Testimonial</h2>
            <p>{{ $testimonial->message }}</p>
        </div>

        <div class="meta-section">
            <div class="meta-item">
                <span class="meta-label">Status:</span>
                <span class="meta-value status-{{ $testimonial->status }}">{{ ucfirst($testimonial->status) }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Views:</span>
                <span class="meta-value">{{ $testimonial->views_count }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Created:</span>
                <span class="meta-value">{{ $testimonial->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

        @if($testimonial->website_url)
            <div class="website-section">
                <a href="{{ $testimonial->website_url }}" target="_blank" rel="noopener noreferrer" class="btn-website">
                    Visit Website
                </a>
            </div>
        @endif

        @if($testimonial->social_links)
            <div class="social-section">
                <h3>Follow</h3>
                <div class="social-links">
                    @foreach($testimonial->social_links as $platform => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="social-link">
                            {{ ucfirst($platform) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="actions-section">
            <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Back to Testimonials</a>
        </div>
    </div>
</div>

<style>
    .testimonial-show-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 20px;
    }

    .testimonial-detail {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .testimonial-detail-header {
        display: flex;
        gap: 24px;
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eee;
    }

    .detail-avatar {
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .detail-info h1 {
        margin: 0 0 8px 0;
        font-size: 24px;
        color: #333;
    }

    .detail-info .designation,
    .detail-info .company,
    .detail-info .location {
        margin: 4px 0;
        color: #666;
        font-size: 14px;
    }

    .rating-section {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eee;
    }

    .stars-large {
        display: flex;
        gap: 4px;
    }

    .stars-large .star {
        font-size: 28px;
        color: #ddd;
    }

    .stars-large .star.filled {
        color: #ffc107;
    }

    .rating-number {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .message-section {
        margin-bottom: 30px;
    }

    .message-section h2 {
        margin: 0 0 12px 0;
        font-size: 18px;
        color: #333;
    }

    .message-section p {
        line-height: 1.8;
        color: #555;
        font-size: 15px;
    }

    .meta-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eee;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .meta-value {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .status-approved {
        color: #28a745;
    }

    .status-pending {
        color: #ffc107;
    }

    .status-rejected {
        color: #dc3545;
    }

    .website-section {
        margin-bottom: 20px;
    }

    .btn-website {
        display: inline-block;
        padding: 10px 20px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background 0.3s;
    }

    .btn-website:hover {
        background: #0056b3;
    }

    .social-section {
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 1px solid #eee;
    }

    .social-section h3 {
        margin: 0 0 12px 0;
        font-size: 14px;
        color: #333;
    }

    .social-links {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .social-link {
        padding: 6px 12px;
        background: #f5f5f5;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        transition: background 0.3s;
    }

    .social-link:hover {
        background: #e9e9e9;
    }

    .actions-section {
        padding-top: 24px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }
</style>
