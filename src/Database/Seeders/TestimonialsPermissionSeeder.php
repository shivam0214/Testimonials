<?php

namespace samkumar\Testimonials\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestimonialsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view testimonials',
            'create testimonials',
            'update testimonials',
            'delete testimonials',
            'approve testimonials',
            'reject testimonials',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get or create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to admin role
        $adminRole->syncPermissions([
            'view testimonials',
            'create testimonials',
            'update testimonials',
            'delete testimonials',
            'approve testimonials',
            'reject testimonials',
        ]);

        // Assign permissions to moderator role
        $moderatorRole->syncPermissions([
            'view testimonials',
            'approve testimonials',
            'reject testimonials',
        ]);

        // Assign permissions to user role
        $userRole->syncPermissions([
            'view testimonials',
            'create testimonials',
            'update testimonials',
        ]);
    }
}
