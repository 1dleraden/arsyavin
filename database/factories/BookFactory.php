<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Pelajaran', 'Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Umum'];
        $stock = fake()->numberBetween(3, 20);

        return [
            'code' => strtoupper(fake()->bothify('???-###')),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'year' => fake()->numberBetween(2015, 2024),
            'category' => fake()->randomElement($categories),
            'stock' => $stock,
            'available_stock' => $stock,
            'shelf_location' => 'Rak '.fake()->randomElement(['A', 'B', 'C', 'D']).'-'.fake()->numberBetween(1, 10),
            'cover_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80',
            'description' => fake()->paragraph(),
        ];
    }
}
