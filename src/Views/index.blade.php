<div class="testimonials-container">
    <div class="testimonials-grid">
        @forelse($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <div class="testimonial-avatar">
                        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="avatar-img">
                    </div>
                    <div class="testimonial-info">
                        <h3 class="testimonial-name">{{ $testimonial->name }}</h3>
                        @if($testimonial->designation)
                            <p class="testimonial-designation">{{ $testimonial->designation }}</p>
                        @endif
                        @if($testimonial->company_name)
                            <p class="testimonial-company">{{ $testimonial->company_name }}</p>
                        @endif
                    </div>
                </div>

                <div class="testimonial-rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $testimonial->rating ? 'filled' : 'empty' }}">★</span>
                        @endfor
                    </div>
                    <span class="rating-value">{{ $testimonial->rating }}.0</span>
                </div>

                <div class="testimonial-message">
                    <p>{{ $testimonial->message }}</p>
                </div>

                <div class="testimonial-footer">
                    <p class="testimonial-location">📍 {{ $testimonial->location }}</p>
                    <p class="testimonial-date">{{ $testimonial->created_at->format('M d, Y') }}</p>
                </div>

                @if($testimonial->website_url)
                    <div class="testimonial-website">
                        <a href="{{ $testimonial->website_url }}" target="_blank" rel="noopener noreferrer">
                            Visit Website →
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="no-testimonials">
                <p>No testimonials available.</p>
            </div>
        @endforelse
    </div>

    @if($testimonials instanceof \Illuminate\Pagination\Paginator)
        <div class="testimonials-pagination">
            {{ $testimonials->links() }}
        </div>
    @endif
</div>

<style>
    .testimonials-container {
        padding: 20px;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .testimonial-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .testimonial-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .testimonial-header {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .testimonial-avatar {
        flex-shrink: 0;
    }

    .avatar-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .testimonial-info {
        flex: 1;
    }

    .testimonial-name {
        margin: 0 0 4px 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .testimonial-designation,
    .testimonial-company {
        margin: 2px 0;
        font-size: 12px;
        color: #666;
    }

    .testimonial-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        font-size: 16px;
        color: #ddd;
    }

    .star.filled {
        color: #ffc107;
    }

    .rating-value {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .testimonial-message {
        margin-bottom: 16px;
        line-height: 1.6;
        color: #555;
        font-size: 14px;
    }

    .testimonial-footer {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #999;
        margin-bottom: 12px;
    }

    .testimonial-website {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .testimonial-website a {
        color: #007bff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }

    .testimonial-website a:hover {
        text-decoration: underline;
    }

    .no-testimonials {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .testimonials-pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
</style>
