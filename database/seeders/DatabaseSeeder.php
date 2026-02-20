<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Sponsor;
use App\Models\SponsoredChild;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          // Create default admins
        DB::table('admins')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@hopeimpact.org',
                'password' => Hash::make('Admin@123'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@hopeimpact.org',
                'password' => Hash::make('Editor@123'),
                'role' => 'editor',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin User',
                'email' => 'adminuser@hopeimpact.org',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

         $child = SponsoredChild::create([
            'first_name' => 'Sokha',
            'code' => 'CAM-2024-001',
            'birth_year' => 2015,
            'story' => 'Sokha dreams of becoming a teacher...',
            'country' => 'Cambodia',
            'is_active' => true,
        ]);

        // Create sponsor and link to child
        Sponsor::create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john@example.com',
            'username' => 'jsmith',
            'password' => bcrypt('password123'),
            'child_id' => $child->id,
            'is_active' => true,
        ]);
    }
}
