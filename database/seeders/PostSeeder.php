<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        if ($user) {
            \App\Models\Post::create([
                'user_id' => $user->id,
                'caption' => 'Ini adalah post percobaan pertama untuk mengecek database! 🎉',
                'image' => 'default.jpg'
            ]);
        }
    }
}
