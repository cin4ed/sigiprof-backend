<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\User;

test('el usuario puede crear una publicacion', function () {
    $publication = [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678',
        'issn_electronico' => null,
        'doi' => '10.1234/abc',
        'nombre_revista' => 'Revista de Prueba',
        'titulo' => 'Título de prueba',
        'anio_publicacion' => 2021,
        'recibio_apoyo_conahcyt' => true,
        'programa_conahcyt' => 'FONDO_INSTITUCIONAL',
        'estatus' => 'PUBLICADO',
        'objetivo' => 'INVESTIGACION',
        'url_cita' => 'https://example.com',
        'cita_a' => 1,
        'cita_b' => 2,
        'total_citas' => 3,
        'eje_conahcyt' => 'DESARROLLO_TECNOLOGIAS',
    ];

    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', $publication);

    $response->assertCreated();
});

test('el usuario puede ver sus publicaciones', function () {
    $user = User::factory()->hasPublications(3)->create();

    $response = $this->actingAs($user)->getJson('/api/v1/user/publications');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('requires a conahcyt program if the publication received support', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678',
        'issn_electronico' => null,
        'doi' => '10.1234/abc',
        'nombre_revista' => 'Revista de Prueba',
        'titulo' => 'Título de prueba',
        'anio_publicacion' => 2021,
        'recibio_apoyo_conahcyt' => true,
        'estatus' => 'PUBLICADO',
        'objetivo' => 'INVESTIGACION',
        'url_cita' => 'https://example.com',
        'cita_a' => 1,
        'cita_b' => 2,
        'total_citas' => 3,
        'eje_conahcyt' => 'DESARROLLO_TECNOLOGIAS',
    ]);

    $response->assertStatus(422);
});

it('doesn\'t require a conahcyt program if the publication didn\'t receive support', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/user/publications', [
        'issn_tipo' => 'IMPRESO',
        'issn_impreso' => '12345678',
        'issn_electronico' => null,
        'doi' => '10.1234/abc',
        'nombre_revista' => 'Revista de Prueba',
        'titulo' => 'Título de prueba',
        'anio_publicacion' => 2021,
        'recibio_apoyo_conahcyt' => false,
        'programa_conahcyt' => null,
        'estatus' => 'PUBLICADO',
        'objetivo' => 'INVESTIGACION',
        'url_cita' => 'https://example.com',
        'cita_a' => 1,
        'cita_b' => 2,
        'total_citas' => 3,
        'eje_conahcyt' => 'DESARROLLO_TECNOLOGIAS',
    ]);

    $response->assertCreated();
});
