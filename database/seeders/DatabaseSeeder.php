<?php

namespace Database\Seeders;

use App\Models\Publication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user
        $admin = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        // Create a token for the user (this will be used in the api documentation)
        $token = new PersonalAccessToken;
        $token->name = 'admin-token';
        $token->token = hash('sha256', $plainTextToken = env('ADMIN_API_TOKEN'));
        $token->abilities = ['*']; // Or specify abilities
        $token->tokenable_id = $admin->id;
        $token->tokenable_type = User::class;
        $token->save();

        Publication::factory(10)->create();
    }
}
