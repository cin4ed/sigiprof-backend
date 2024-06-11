<?php

namespace Tests\Feature\Http\Controllers\V1;

use App\Models\Publication;
use App\Models\User;

test('el usuario puede ver todas las publicaciones', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/v1/publications');

    $response->assertOk();
});

test('el usuario puede ver una publicacion', function () {
    $user = User::factory()->create();

    $publication = Publication::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/v1/publications/{$publication->id}");

    $response->assertOk();
});

test('el usuario puede actualizar una publicacion', function () {
    $user = User::factory()->create();

    $publication = Publication::factory()->create();

    $response = $this->actingAs($user)->putJson("/api/v1/publications/{$publication->id}", [
        'issn_tipo' => 'impreso',
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
    ]);

    $response->assertOk();
});
