<?php

namespace samkumar\Testimonials\Database\Seeders;

use Illuminate\Database\Seeder;
use samkumar\Testimonials\Database\Factories\TestimonialFactory;
use samkumar\Testimonials\Models\Testimonial;

class TestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create approved testimonials
        Testimonial::factory()
            ->count(8)
            ->approved()
            ->create();

        // Create pending testimonials
        Testimonial::factory()
            ->count(5)
            ->pending()
            ->create();

        // Create rejected testimonials
        Testimonial::factory()
            ->count(2)
            ->rejected()
            ->create();

        // Create high-rated testimonials
        Testimonial::factory()
            ->count(5)
            ->approved()
            ->create([
                'rating' => 5,
            ]);
    }
}
