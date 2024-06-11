<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Course;
use App\Models\User;

it('allows to list all courses', function () {
    $user = User::factory()->create();

    $user->courses()->saveMany(Course::factory()->count(3)->make());

    $response = $this->actingAs($user)->getJson('/api/v1/courses');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('allows to see a course', function () {
    $user = User::factory()->create();

    $user->courses()->saveMany(Course::factory()->count(3)->make());

    $course = $user->courses->first();

    $response = $this->actingAs($user)->getJson("/api/v1/courses/{$course->id}");

    $response->assertOk();
});

it('allows to update a course', function () {
    $user = User::factory()->create();

    $user->courses()->saveMany(Course::factory()->count(3)->make());

    $course = $user->courses->first();

    $response = $this->actingAs($user)->putJson("/api/v1/courses/{$course->id}", [
        'tipo_formacion' => 'CURSO',
        'nombre' => 'Curso de prueba',
        'anio' => 2021,
        'horas_totales' => 40,
        'institucion' => 'Institución de prueba',
        'tipo_institucion' => 'NACIONAL',
        'modalidad_institucion' => 'PRIVADA',
        'descripcion' => 'Descripción de prueba',
    ]);

    $response->assertOk();

    $response->assertJsonFragment([
        'tipo_formacion' => 'CURSO',
        'nombre' => 'Curso de prueba',
        'anio' => 2021,
        'horas_totales' => 40,
        'institucion' => 'Institución de prueba',
        'tipo_institucion' => 'NACIONAL',
        'modalidad_institucion' => 'PRIVADA',
        'descripcion' => 'Descripción de prueba',
    ]);
});

it('allows to delete a course', function () {
    $user = User::factory()->create();

    $user->courses()->saveMany(Course::factory()->count(3)->make());

    $course = $user->courses->first();

    $response = $this->actingAs($user)->deleteJson("/api/v1/courses/{$course->id}");

    $response->assertNoContent();
});
