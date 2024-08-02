<?php

namespace Database\Seeders;

use App\Services\Role\RoleService;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleService::createAllRoles();
    }
}
