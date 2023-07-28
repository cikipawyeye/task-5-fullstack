<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
        ]);
        
        // \App\Models\Category::factory()->create([
        //     'name' => 'Testing',
        //     'user_id' => '1',
        // ]);

        \App\Models\Category::create([
            'name' => 'Testing',
            'user_id' => '1',
        ]);
    }
}
