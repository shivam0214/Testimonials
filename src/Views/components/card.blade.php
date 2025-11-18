<div class="testimonials-widget">
    <div class="testimonial-card-minimal">
        <div class="rating-stars">
            @for($i = 1; $i <= 5; $i++)
                <span class="star {{ $i <= $testimonial->rating ? 'filled' : '' }}">★</span>
            @endfor
        </div>
        <p class="testimonial-text">{{ Str::limit($testimonial->message, 150) }}</p>
        <p class="testimonial-author">{{ $testimonial->name }}</p>
        <p class="testimonial-position">{{ $testimonial->designation }} {{ $testimonial->company_name ? '@ ' . $testimonial->company_name : '' }}</p>
    </div>
</div>

<style>
    .testimonials-widget {
        padding: 20px;
    }

    .testimonial-card-minimal {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 20px;
        border-radius: 4px;
    }

    .rating-stars {
        margin-bottom: 12px;
    }

    .star {
        color: #ddd;
        font-size: 14px;
        margin-right: 2px;
    }

    .star.filled {
        color: #ffc107;
    }

    .testimonial-text {
        margin: 12px 0;
        font-size: 14px;
        line-height: 1.6;
        color: #555;
        font-style: italic;
    }

    .testimonial-author {
        margin: 12px 0 4px 0;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .testimonial-position {
        margin: 0;
        font-size: 12px;
        color: #999;
    }
</style>
