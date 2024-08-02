<?php

namespace App\Services\Role;

use Spatie\Permission\Models\Role;

class RoleService
{
    public static function createAllRoles()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'attendant',
                'guard_name' => 'api',
            ],
            [
                'id' => 2,
                'name' => 'doctor',
                'guard_name' => 'api',
            ],
            [
                'id' => 3,
                'name' => 'recepcionist',
                'guard_name' => 'api',
            ],
            [
                'id' => 4,
                'name' => 'admin',
                'guard_name' => 'api',
            ],
        ];
        foreach ($roles as $role) {
            self::createRole($role);
        }
    }
    public static function createRole(array $role): Role
    {
        return Role::firstOrCreate($role);
    }
}
