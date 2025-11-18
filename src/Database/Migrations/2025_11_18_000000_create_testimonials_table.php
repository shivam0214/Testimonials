<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('location');
            $table->text('message');
            $table->string('photo')->nullable();
            $table->integer('rating')->default(5)->comment('Rating from 1 to 5');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('website_url')->nullable();
            $table->text('social_links')->nullable(); // JSON
            $table->integer('views_count')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('status');
            $table->index('rating');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
