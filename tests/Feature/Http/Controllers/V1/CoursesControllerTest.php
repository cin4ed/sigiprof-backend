<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Course;
use App\Models\User;

test('permite listar todos los cursos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Crear cursos asociados al usuario autenticado
    Course::factory()->count(3)->create(['usuario_id' => $user->id]);

    $response = $this->getJson('/api/v1/courses');

    $response->assertOk();
    $response->assertJsonCount(3);
});

test('permite ver un curso específico', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $course = Course::factory()->create(['usuario_id' => $user->id]);

    $response = $this->getJson("/api/v1/courses/{$course->id}");

    $response->assertOk();
    $response->assertJsonFragment([
        'id' => $course->id,
        'nombre' => $course->nombre,
    ]);
});

test('permite actualizar un curso con datos válidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $course = Course::factory()->create([
        'usuario_id' => $user->id,
        'tipo_formacion' => 'CURSO',
        'nombre' => 'Curso Original',
        'anio' => 2021,
        'horas_totales' => 40,
        'institucion' => 'Instituto Original',
        'tipo_institucion' => 'NACIONAL',
    ]);

    $updatedData = [
        'tipo_formacion' => 'DIPLOMADO',
        'nombre' => 'Curso Actualizado',
        'anio' => 2022,
        'horas_totales' => 50,
        'institucion' => 'Instituto Actualizado',
        'tipo_institucion' => 'EXTRANJERA',
    ];

    $response = $this->putJson("/api/v1/courses/{$course->id}", $updatedData);

    $response->assertOk();
    $response->assertJsonFragment($updatedData);
    $this->assertDatabaseHas('cursos', $updatedData + ['usuario_id' => $user->id]);
});

test('falla al actualizar un curso con datos inválidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $course = Course::factory()->create(['usuario_id' => $user->id]);

    $invalidData = [
        'tipo_formacion' => 'INVALIDO', // Tipo no permitido
        'nombre' => '', // Nombre requerido
        'anio' => 'no_es_un_entero', // Dato inválido
        'horas_totales' => -5, // Dato inválido
        'institucion' => '', // Institución requerida
        'tipo_institucion' => 'INVALIDO', // Tipo no permitido
    ];

    $response = $this->putJson("/api/v1/courses/{$course->id}", $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'tipo_formacion',
        'nombre',
        'anio',
        'horas_totales',
        'institucion',
        'tipo_institucion',
    ]);
});

test('permite eliminar un curso', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $course = Course::factory()->create(['usuario_id' => $user->id]);

    $response = $this->deleteJson("/api/v1/courses/{$course->id}");

    $response->assertNoContent();
    $this->assertSoftDeleted('cursos', ['id' => $course->id]);
});
