<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);
        $isPublished = fake()->boolean(70);
        $targetType = fake()->randomElement(['all', 'all', 'division']);

        return [
            'title' => $title,
            'slug' => null, // auto-generate di booted()
            'excerpt' => fake()->paragraph(2),
            'body' => fake()->paragraphs(4, true),
            'target_type' => $targetType,
            'target_division_id' => $targetType === 'division'
                ? Division::query()->inRandomOrder()->value('id')
                : null,
            'priority' => fake()->randomElement(['low', 'normal', 'normal', 'high', 'urgent']),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? fake()->dateTimeBetween('-2 months', 'now') : null,
            'expires_at' => fake()->boolean(30) ? fake()->dateTimeBetween('now', '+3 months') : null,
            'created_by' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
    }
}
