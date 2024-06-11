<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;

it('allows users to logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertStatus(200);
    $this->assertGuest();
});
