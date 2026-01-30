<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'code' => Str::random(6),
            'original_url' => fake()->url(),
            'title' => fake()->optional()->sentence(3),
            'is_active' => true,
            'expires_at' => null,
            'click_count' => fake()->numberBetween(0, 1000),
            'max_views' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'expires_at' => now()->subDay(),
        ]);
    }

    public function maxViewsReached(): static
    {
        return $this->state(fn (array $attributes): array => [
            'max_views' => 10,
            'click_count' => 10,
        ]);
    }

    public function withMaxViews(int $maxViews): static
    {
        return $this->state(fn (array $attributes): array => [
            'max_views' => $maxViews,
            'click_count' => 0,
        ]);
    }

    public function withoutUser(): static
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => null,
        ]);
    }
}
