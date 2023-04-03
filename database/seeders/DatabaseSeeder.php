<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profile;
use App\Models\User;
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

        $users = User::all();

        foreach ($users as $user) {
            Profile::factory()->create([
                'user_id' => $user->id,
                'created_at' => $user->created_at,
            ]);
        }
    }
}
