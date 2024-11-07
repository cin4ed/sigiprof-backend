<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Course;
use App\Models\User;

it('permite al usuario obtener todos sus cursos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Crear cursos asociados al usuario autenticado
    $courses = Course::factory()->count(3)->create(['usuario_id' => $user->id]);

    $response = $this->getJson('/api/v1/user/courses');

    $response->assertOk();
    $response->assertJsonCount(3);
    $response->assertJsonFragment([
        'id' => $courses[0]->id,
        'nombre' => $courses[0]->nombre,
    ]);
});

it('el usuario no puede ver cursos de otros usuarios', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $this->actingAs($user);

    // Crear cursos asociados solo al otro usuario
    $otherCourses = Course::factory()->count(2)->create(['usuario_id' => $otherUser->id]);

    $response = $this->getJson('/api/v1/user/courses');

    $response->assertOk();
    $response->assertJsonMissing(['id' => $otherCourses[0]->id]);
    $response->assertJsonMissing(['id' => $otherCourses[1]->id]);
});

it('permite al usuario crear un curso con datos válidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $courseData = [
        'tipo_formacion' => 'CURSO',
        'nombre' => 'Curso de Desarrollo',
        'anio' => 2023,
        'horas_totales' => 40,
        'institucion' => 'Instituto de Tecnología',
        'tipo_institucion' => 'NACIONAL',
    ];

    $response = $this->postJson('/api/v1/user/courses', $courseData);

    $response->assertStatus(201); // Created
    $response->assertJsonFragment($courseData);

    // Verificar que el curso está en la base de datos con el usuario_id correcto
    $this->assertDatabaseHas('cursos', $courseData + ['usuario_id' => $user->id]);
});

it('falla al crear un curso con datos inválidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $invalidData = [
        'tipo_formacion' => 'INVALIDO', // Tipo no permitido
        'nombre' => '', // Nombre requerido
        'anio' => 'no_es_un_entero', // Dato inválido
        'horas_totales' => -5, // Dato inválido
        'institucion' => '', // Institución requerida
        'tipo_institucion' => 'INVALIDO', // Tipo de institución no permitido
    ];

    $response = $this->postJson('/api/v1/user/courses', $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'tipo_formacion',
        'nombre',
        'anio',
        'horas_totales',
        'institucion',
        'tipo_institucion'
    ]);
});

it('un usuario sin autenticación no puede ver ni crear cursos', function () {
    $courseData = [
        'tipo_formacion' => 'CURSO',
        'nombre' => 'Curso de Seguridad Informática',
        'anio' => 2023,
        'horas_totales' => 30,
        'institucion' => 'Academia de Ciencias',
        'tipo_institucion' => 'EXTRANJERA',
    ];

    $responseIndex = $this->getJson('/api/v1/user/courses');
    $responseStore = $this->postJson('/api/v1/user/courses', $courseData);

    $responseIndex->assertStatus(401); // No autorizado
    $responseStore->assertStatus(401); // No autorizado
});
