<?php

namespace Tests\Feature\Models;

use App\Models\Course;
use App\Models\User;

it('can create a course for a user', function () {
    $user = User::factory()->create();

    $user->courses()->create(Course::factory()->make()->toArray());

    expect($user->courses->count())->toBe(1);
});
