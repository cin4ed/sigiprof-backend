<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;

it('allows users to login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertAuthenticated();
});
