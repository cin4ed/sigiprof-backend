<?php

namespace Tests\Feature\Models;

use App\Models\Publication;
use App\Models\User;

it('can create a publication for a user', function () {
    $publication = Publication::factory()->create();
    $user = User::factory()->create();

    $user->publications()->attach($publication, ['rol' => 'AUTOR']);

    expect($user->publications->first()->id)->toBe($publication->id);
    expect($user->publications->first()->pivot->rol)->toBe('AUTOR');
});
