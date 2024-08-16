<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'root',
            'email' => 'root@app.com',
            'role' => 'root',
            'level' => 1,
            'password' => bcrypt('sekarep12345')
        ]);
        User::create([
            'name' => 'owner',
            'email' => 'owner@app.com',
            'role' => 'owner',
            'level' => 2,
            'password' => bcrypt('123456')
        ]);
    }
}
