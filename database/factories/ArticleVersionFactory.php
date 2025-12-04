<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleVersion>
 */
class ArticleVersionFactory extends Factory
{
    const int WORDS_PER_MINUTE = 200;

    public function definition(): array
    {
        $paragraphCount = fake()->numberBetween(5, 30);
        /** @var string $content */
        $content = fake()->paragraphs($paragraphCount, true);
        $title = fake()->sentence();

        $wordCount = str_word_count($content);
        $readingTime = (int) ceil(($wordCount / 200) * 60);

        return [
            'article_id' => Article::factory(),
            'content' => $content,
            'content_hash' => hash('sha256', $content),
            'title' => $title,
            'author' => fake()->optional(0.8)->name(),
            'reading_time' => $readingTime,
            'word_count' => $wordCount,
            'metadata' => [
                'og:title' => $title,
                'og:description' => fake()->sentence(),
                'change_type' => fake()->randomElement(['minor_edit', 'major_update', 'correction']),
            ],
            'fetched_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
