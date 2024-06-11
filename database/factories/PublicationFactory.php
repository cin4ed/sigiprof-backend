<?php

namespace Database\Factories;

use App\Helpers\ConahcytProgramas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'issn_tipo' => $this->faker->randomElement(['IMPRESO', 'ELECTRONICO', 'AMBOS']),
            'issn_impreso' => $this->faker->optional()->regexify('[0-9]{8}'),
            'issn_electronico' => $this->faker->optional()->regexify('[0-9]{8}'),
            'doi' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'nombre_revista' => $this->faker->sentence(3),
            'titulo' => $this->faker->sentence(6),
            'anio_publicacion' => $this->faker->numberBetween(2000, 2022),
            'recibio_apoyo_conahcyt' => $this->faker->boolean(),
            'estatus' => $this->faker->randomElement(['PUBLICADO', 'ACEPTADO']),
            'objetivo' => $this->faker->randomElement(['INVESTIGACION', 'TRABAJO_DIFUSION', 'LIBROS_DOCENCIA']),
            'url_cita' => $this->faker->url(),
            'cita_a' => $this->faker->numberBetween(0, 100),
            'cita_b' => $this->faker->numberBetween(0, 100),
            'total_citas' => $this->faker->numberBetween(0, 100),
            'eje_conahcyt' => $this->faker->randomElement(['DESARROLLO_TECNOLOGIAS', 'DIFUSION_CIENCIA', 'FORTALECIMIENTO_COMUNIDAD', 'IMPULSO_FRONTERAS', 'INCIDENCIA_PROBLEMATICAS']),
            'programa_conahcyt' => $this->faker->randomElement(ConahcytProgramas::all()),
        ];
    }
}
