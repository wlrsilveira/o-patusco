<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            AnimalTypeSeeder::class,
        ]);

        if (! User::where('email','admin@admin.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
            ]);
            $user->assignRole('admin');
        }
    }
}
