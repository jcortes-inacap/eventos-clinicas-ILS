<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(10)->create();

        foreach ($users as $user) {
            Post::create([
                'title' => 'Post de ' . $user->name,
                'content' => 'Contenido demo para ' . $user->name,
                'user_id' => $user->id
            ]);
        }


    }
}
