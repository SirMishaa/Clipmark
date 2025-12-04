<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Misha',
            'email' => 'mishaaa.pro@proton.me',
            'password' => Hash::make('mishaa.pro@proton.me'),
        ]);

        $articles = Article::factory()->count(15)->create();

        foreach ($articles->take(10) as $index => $article) {
            Bookmark::factory()
                ->for($user)
                ->for($article, 'bookmarkable')
                ->when($index < 3, fn ($factory) => $factory->starred())
                ->when($index >= 5, fn ($factory) => $factory->read())
                ->when($index === 9, fn ($factory) => $factory->archived())
                ->create();
        }

        $articles->random(3)->each(function ($article) {
            $article->createVersion();
        });
    }
}
