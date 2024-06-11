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
            'recibio_apoyo_conahcyt' => $this->faker->boolean(),
            'programa_conahcyt' => $this->faker->randomElement(\App\Helpers\ConahcytProgramas::all()),
            'esta_dictaminado' => $this->faker->boolean(),
            'url_cita' => $this->faker->url(),
            'cita_a' => $this->faker->numberBetween(1, 100),
            'cita_b' => $this->faker->numberBetween(1, 100),
            'total_citas' => $this->faker->numberBetween(1, 100),
            'estado_publicacion' => $this->faker->randomElement(\App\Helpers\LibroEstados::all()),
        ];
    }
}
