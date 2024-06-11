<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Publication;
use App\Models\User;

it('allows to list authors of a publication', function () {
    $user = User::factory()->create();
    $publication = $user->publications()->create(Publication::factory()->make()->toArray());

    $response = $this->actingAs($user)->get("api/v1/publications/{$publication->id}/authors");

    $response->assertStatus(200);
    $response->assertJson([]);
});

it('allows authors to be added to a publication', function () {
    $user = User::factory()->create();
    $publication = $user->publications()->create(Publication::factory()->make()->toArray());

    $response = $this->actingAs($user)->post("api/v1/publications/{$publication->id}/authors", [
        'nombre' => 'John',
        'primer_apellido' => 'Doe',
        'segundo_apellido' => 'Smith',
        'orc_id' => '0000000000000000',
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'nombre' => 'John',
        'primer_apellido' => 'Doe',
        'segundo_apellido' => 'Smith',
        'orc_id' => '0000000000000000',
    ]);
});
