<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\User;
use App\Models\Publication;

test('el usuario puede crear una publicación con todos los datos válidos', function () {
    $publication = [
        'issn_tipo' => 'ELECTRONICO',
        'issn_impreso' => null,
        'issn_electronico' => '87654321',
        'doi' => '10.1234/def',
        'nombre_revista' => 'Otra Revista',
        'titulo' => 'Otro título de prueba',
        'anio_publicacion' => 2022,
        'estatus' => 'ACEPTADO',
    ];

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', $publication);

    $response->assertCreated();
});

test('falla al crear una publicación si falta un campo requerido', function () {
    $publication = [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => null, // Campo requerido cuando issn_tipo es IMPRESO
        'issn_electronico' => null,
        'doi' => null, // Campo requerido
        'nombre_revista' => 'Revista de Prueba',
        'titulo' => 'Título de prueba',
        'anio_publicacion' => 2021,
        'estatus' => 'PUBLICADO',
    ];

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', $publication);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['issn_impreso', 'doi']);
});

test('falla al crear una publicación si el ISSN o DOI no es único', function () {
    $user = User::factory()->create();

    Publication::factory()->create([
        'issn_impreso' => '12345678',
        'issn_electronico' => '87654321',
        'doi' => '10.1234/ghi',
    ]);

    $publication = [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678', // No es único
        'issn_electronico' => '87654321', // No es único
        'doi' => '10.1234/ghi', // No es único
        'nombre_revista' => 'Revista Duplicada',
        'titulo' => 'Título duplicado',
        'anio_publicacion' => 2023,
        'estatus' => 'PUBLICADO',
    ];

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', $publication);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['issn_impreso', 'issn_electronico', 'doi']);
});

test('un usuario no autenticado no puede crear una publicación', function () {
    $publication = [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678',
        'issn_electronico' => null,
        'doi' => '10.1234/jkl',
        'nombre_revista' => 'Revista de Ejemplo',
        'titulo' => 'Título de Ejemplo',
        'anio_publicacion' => 2024,
        'estatus' => 'PUBLICADO',
    ];

    $response = $this->postJson('/api/v1/user/publications', $publication);

    $response->assertStatus(401);
});

test('el usuario puede obtener todas sus publicaciones', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Crear publicaciones y asignarlas al usuario autenticado
    $publications = Publication::factory()->count(3)->create();
    $user->publications()->attach($publications);

    $response = $this->getJson('/api/v1/user/publications');

    $response->assertOk();
    $response->assertJsonCount(3);
    $response->assertJsonFragment([
        'id' => $publications[0]->id,
        'titulo' => $publications[0]->titulo,
    ]);
});

test('el usuario no puede ver publicaciones de otros usuarios', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $this->actingAs($user);

    // Crear publicaciones y asignarlas solo al otro usuario
    $otherPublications = Publication::factory()->count(2)->create();
    $otherUser->publications()->attach($otherPublications);

    $response = $this->getJson('/api/v1/user/publications');

    $response->assertOk();
    $response->assertJsonMissing(['id' => $otherPublications[0]->id]);
    $response->assertJsonMissing(['id' => $otherPublications[1]->id]);
});

test('un usuario sin autenticación no puede obtener publicaciones', function () {
    $response = $this->getJson('/api/v1/user/publications');

    $response->assertStatus(401); // No autorizado
});
