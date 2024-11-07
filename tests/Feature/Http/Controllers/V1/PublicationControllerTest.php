<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Publication;
use App\Models\User;

test('el usuario puede ver todas las publicaciones', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Crear varias publicaciones
    Publication::factory()->count(5)->create();

    $response = $this->getJson('/api/v1/publications');

    $response->assertOk();
    $response->assertJsonCount(5);
});

test('el usuario puede ver una publicación específica', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $publication = Publication::factory()->create();

    $response = $this->getJson("/api/v1/publications/{$publication->id}");

    $response->assertOk();
    $response->assertJsonFragment([
        'id' => $publication->id,
        'titulo' => $publication->titulo,
    ]);
});

test('el usuario puede actualizar una publicación', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $publication = Publication::factory()->create([
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678',
        'issn_electronico' => null,
        'doi' => '10.1234/abc',
        'nombre_revista' => 'Revista Inicial',
        'titulo' => 'Título inicial',
        'anio_publicacion' => 2020,
        'estatus' => 'ACEPTADO',
    ]);

    $updatedData = [
        'issn_tipo' => 'ELECTRONICO',
        'issn_impreso' => null,
        'issn_electronico' => '87654321',
        'doi' => '10.5678/def',
        'nombre_revista' => 'Revista Actualizada',
        'titulo' => 'Título actualizado',
        'anio_publicacion' => 2021,
        'estatus' => 'PUBLICADO',
    ];

    $response = $this->putJson("/api/v1/publications/{$publication->id}", $updatedData);

    $response->assertOk();
    $response->assertJsonFragment($updatedData);
    $this->assertDatabaseHas('publicaciones', [
        'id' => $publication->id,
        'titulo' => 'Título actualizado',
        'nombre_revista' => 'Revista Actualizada',
    ]);
});

test('el usuario recibe error de validación al actualizar una publicación con datos inválidos', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $publication = Publication::factory()->create(['issn_tipo' => 'IMPRESO']);

    $invalidData = [
        'issn_tipo' => 'INVALIDO', // Valor no permitido
        'doi' => '', // Campo requerido
        'anio_publicacion' => 'no es un número', // Dato inválido
    ];

    $response = $this->putJson("/api/v1/publications/{$publication->id}", $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['issn_tipo', 'doi', 'anio_publicacion']);
});

test('el usuario puede eliminar una publicación (soft delete)', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $publication = Publication::factory()->create();

    $response = $this->deleteJson("/api/v1/publications/{$publication->id}");

    $response->assertNoContent();

    // Confirm the record still exists but has a deleted_at timestamp
    $this->assertSoftDeleted('publicaciones', [
        'id' => $publication->id,
    ]);
});

test('un usuario sin autenticación no puede acceder a las publicaciones', function () {
    $publication = Publication::factory()->create();

    $responseIndex = $this->getJson('/api/v1/publications');
    $responseShow = $this->getJson("/api/v1/publications/{$publication->id}");
    $responseUpdate = $this->putJson("/api/v1/publications/{$publication->id}", ['titulo' => 'Nuevo Título']);
    $responseDelete = $this->deleteJson("/api/v1/publications/{$publication->id}");

    $responseIndex->assertStatus(401);
    $responseShow->assertStatus(401);
    $responseUpdate->assertStatus(401);
    $responseDelete->assertStatus(401);
});
