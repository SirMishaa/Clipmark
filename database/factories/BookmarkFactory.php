<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $savedAt = fake()->dateTimeBetween('-6 months', 'now');
        $isRead = fake()->boolean(40);

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'excerpt' => fake()->optional()->paragraph(),
            'is_starred' => fake()->boolean(20),
            'is_read' => $isRead,
            'is_archived' => fake()->boolean(10),
            'read_at' => $isRead ? fake()->dateTimeBetween($savedAt, 'now') : null,
            'saved_at' => $savedAt,
        ];
    }

    public function starred(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_starred' => true,
        ]);
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => true,
            'read_at' => fake()->dateTimeBetween($attributes['saved_at'], 'now'),
        ]);
    }

    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_archived' => true,
        ]);
    }
}
