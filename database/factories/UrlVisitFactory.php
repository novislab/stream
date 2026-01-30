<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\UrlVisit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UrlVisit>
 */
class UrlVisitFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'short_url_id' => ShortUrl::factory(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'referer' => fake()->optional()->url(),
            'country' => fake()->countryCode(),
            'city' => fake()->city(),
            'device' => fake()->randomElement(['Desktop', 'Mobile', 'Tablet']),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'platform' => fake()->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
        ];
    }
}
