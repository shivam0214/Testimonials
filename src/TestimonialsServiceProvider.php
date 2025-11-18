<?php

namespace samkumar\Testimonials;

use Illuminate\Support\ServiceProvider;

class TestimonialsServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        // Register migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        // Register views
        $this->loadViewsFrom(__DIR__ . '/Views', 'testimonials');

        // Publish assets
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/testimonials'),
        ], 'testimonials-views');

        $this->publishes([
            __DIR__ . '/Database/Migrations' => database_path('migrations'),
        ], 'testimonials-migrations');

        $this->publishes([
            __DIR__ . '/Config/testimonials.php' => config_path('testimonials.php'),
        ], 'testimonials-config');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/Config/testimonials.php',
            'testimonials'
        );

        // Register the factory
        $this->app->make('Illuminate\Database\Eloquent\Factory')
            ->load(__DIR__ . '/Database/Factories');
    }
}
