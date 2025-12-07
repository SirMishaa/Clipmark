<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $paragraphCount = fake()->numberBetween(5, 30);
        $content = fake()->paragraphs($paragraphCount, true);
        $title = fake()->sentence();

        $wordCount = str_word_count($content);
        $readingTime = (int) ceil(($wordCount / 200) * 60);

        $publishedAt = fake()->optional(0.8)->dateTimeBetween('-2 years', 'now');
        $lastFetchedAt = $publishedAt
            ? fake()->dateTimeBetween($publishedAt, 'now')
            : fake()->dateTimeBetween('-1 month', 'now');

        $siteName = fake()->randomElement([
            'Medium',
            'Dev.to',
            'Smashing Magazine',
            'CSS-Tricks',
            'freeCodeCamp',
            'Hacker Noon',
            'The Verge',
            'TechCrunch',
            'Ars Technica',
            fake()->company(),
        ]);

        return [
            'url' => fake()->unique()->url(),
            'canonical_url' => fake()->optional(0.3)->url(),
            'title' => $title,
            'excerpt' => fake()->optional(0.7)->paragraph(),
            'content' => $content,
            'content_hash' => hash('sha256', $content),
            'author' => fake()->optional(0.8)->name(),
            'site_name' => $siteName,
            'published_at' => $publishedAt,
            'reading_time' => $readingTime,
            'word_count' => $wordCount,
            'language' => fake()->randomElement(['en', 'fr', 'es', 'de']),
            'featured_image_url' => 'https://picsum.photos/seed/'.fake()->unique()->numberBetween(1, 10000).'/800/400',
            'favicon_url' => fake()->optional(0.9)->imageUrl(32, 32),
            'metadata' => [
                'og:title' => $title,
                'og:description' => fake()->sentence(),
                'og:type' => 'article',
                'og:site_name' => $siteName,
            ],
            'last_fetched_at' => $lastFetchedAt,
        ];
    }

    public function withVersion(): static
    {
        return $this->afterCreating(function (Article $article) {
            $article->createVersion();
        });
    }
}
