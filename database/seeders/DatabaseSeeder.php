<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'username' => env('ADMIN_USERNAME'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'role' => env('ADMIN_ROLE'),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'username' => 'Tasker' . $i,
                'password' => bcrypt('password123'),
                'role' => 'tasker',
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'username' => 'Worker' . $i,
                'password' => bcrypt('password123'),
                'role' => 'worker',
            ]);
        }

        $tasker = User::where('role', 'tasker')->first();
        for ($i = 1; $i <= 10; $i++) {
            Job::create([
                'title' => 'Job' . $i,
                'description' => 'Description' . $i,
                'user_id' => $tasker->id,
            ]);
        }
    }
}
