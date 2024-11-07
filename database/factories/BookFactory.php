<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
        return [
            'isbn' => $this->faker->isbn13(),
            'doi' => $this->faker->unique()->isbn13(),
            'titulo' => $this->faker->sentence(),
            'anio_publicacion' => (int) $this->faker->year(),
            'editorial' => $this->faker->company(),
            'pais' => $this->faker->country(),
            'idioma' => $this->faker->languageCode(),
            'estado_publicacion' => $this->faker->randomElement(\App\Helpers\LibroEstados::all()),
        ];
    }
}
