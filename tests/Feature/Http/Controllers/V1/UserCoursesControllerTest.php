<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Course;
use App\Models\User;

it('allows to list all courses for a user', function () {
    $user = User::factory()->create();

    $user->courses()->saveMany(Course::factory()->count(3)->make());

    $response = $this->actingAs($user)->getJson('/api/v1/user/courses');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('allows to create courses for a user', function () {
    $course = [
        'tipo_formacion' => 'ACREDITACION',
        'nombre' => 'Curso de prueba',
        'anio' => 2021,
        'horas_totales' => 40,
        'institucion' => 'Institución de prueba',
        'tipo_institucion' => 'NACIONAL',
        'modalidad_institucion' => 'PUBLICA_FEDERAL',
        'descripcion' => 'Descripción de prueba',
    ];

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/courses', $course);

    $response->assertCreated();
});
