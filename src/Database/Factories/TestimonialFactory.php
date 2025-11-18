<?php

namespace samkumar\Testimonials\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use samkumar\Testimonials\Models\Testimonial;

class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $locations = ['New York, USA', 'London, UK', 'Toronto, Canada', 'Sydney, Australia', 'Tokyo, Japan', 'Berlin, Germany', 'Mumbai, India', 'Dubai, UAE'];
        $companies = ['Tech Corp', 'Innovation Labs', 'Digital Solutions', 'Creative Agency', 'Cloud Systems', 'Data Analytics Co', 'Web Services Inc', 'Software House'];
        $designations = ['CEO', 'Manager', 'Developer', 'Designer', 'Business Analyst', 'Project Lead', 'CTO', 'Marketing Director'];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'location' => $this->faker->randomElement($locations),
            'message' => $this->faker->paragraph(4),
            'rating' => $this->faker->numberBetween(3, 5),
            'status' => $this->faker->randomElement(['approved', 'pending', 'rejected']),
            'company_name' => $this->faker->randomElement($companies),
            'designation' => $this->faker->randomElement($designations),
            'website_url' => $this->faker->url(),
            'social_links' => [
                'twitter' => 'https://twitter.com/' . $this->faker->userName(),
                'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName(),
                'instagram' => 'https://instagram.com/' . $this->faker->userName(),
            ],
            'views_count' => $this->faker->numberBetween(0, 500),
            'user_id' => null,
        ];
    }

    /**
     * State for approved testimonials.
     */
    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
            ];
        });
    }

    /**
     * State for pending testimonials.
     */
    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    /**
     * State for rejected testimonials.
     */
    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
            ];
        });
    }
}
