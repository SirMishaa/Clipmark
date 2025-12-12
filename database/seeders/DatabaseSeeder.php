<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'mishaa.pro@proton.me',
            'email' => 'mishaa.pro@proton.me',
            'password' => 'mishaa.pro@proton.me',
            'two_factor_confirmed_at' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_secret' => null,
        ]);

        $articles = Article::factory()->count(50)->create();

        foreach ($articles->take(40) as $index => $article) {
            Bookmark::factory()
                ->for($user)
                ->for($article, 'bookmarkable')
                ->when($index < 3, fn ($factory) => $factory->starred())
                ->when($index >= 5, fn ($factory) => $factory->read())
                ->when($index === 9, fn ($factory) => $factory->archived())
                ->create();
        }

        $articles->random(4)->each(function ($article) {
            $article->createVersion();
        });
    }
}
