<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@user.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@user.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        Todo::factory(10)->create();
        // Todo::create([
        //     'user_id' => 1,
        //     'task' => 'Lorem ipsum dolor sit amet.',
        //     'is_completed' => false,
        // ]);
        // Todo::create([
        //     'user_id' => 1,
        //     'task' => ' Lorem ipsum dolor sit amet.  Lorem ipsum dolor sit amet.',
        //     'is_completed' => false,
        // ]);
    }
}
