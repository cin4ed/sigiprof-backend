<?php

namespace Database\Seeders;

use App\Models\Publication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        Publication::factory(10)->create();
    }
}
