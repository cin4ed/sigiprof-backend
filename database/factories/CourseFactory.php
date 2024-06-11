<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_formacion' => $this->faker->randomElement(['ACREDITACION', 'CERTIFICACION', 'COACHING', 'CURSO', 'DIPLOMADO', 'SEMINARIO', 'TALLER']),
            'nombre' => $this->faker->sentence(3),
            'anio' => $this->faker->numberBetween(2000, 2022),
            'horas_totales' => $this->faker->numberBetween(1, 100),
            'institucion' => $this->faker->sentence(3),
            'tipo_institucion' => $this->faker->randomElement(['EXTRANJERA', 'NACIONAL']),
            'modalidad_institucion' => $this->faker->randomElement(['PUBLICA_FEDERAL', 'PUBLICA_ESTATAL', 'PUBLICA_MUNICIPAL', 'PRIVADA']),
            'descripcion' => $this->faker->paragraph(),
        ];
    }
}
