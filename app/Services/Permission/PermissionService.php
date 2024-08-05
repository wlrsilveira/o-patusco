<?php

namespace App\Services\Permission;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    public static function createAllPermissions()
    {
        self::createAttendantPermissions();
        self::createDoctorPermissions();
        self::createRecepcionistPermissions();
        self::createAdminPermissions();
    }
    public static function createAttendantPermissions()
    {
        $permissions = [
            [
                'name'       => 'schedule_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'show_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
        ];

        $createdPermissions = [];

        foreach ($permissions as $permission) {
            if (Permission::whereName($permission['name'])->first() == null) {
                self::createPermission($permission);
                array_push($createdPermissions, $permission['name']);
            } else {
                array_push($createdPermissions, $permission['name']);
            }
        }

        $role = Role::where('name', 'attendant')->first();
        $role->syncPermissions($createdPermissions);
    }
    public static function createDoctorPermissions()
    {
        $permissions = [
            [
                'name'       => 'view_my_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'update_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
        ];

        $createdPermissions = [];

        foreach ($permissions as $permission) {
            if (Permission::whereName($permission['name'])->first() == null) {
                self::createPermission($permission);
                array_push($createdPermissions, $permission['name']);
            } else {
                array_push($createdPermissions, $permission['name']);
            }
        }

        $role = Role::where('name', 'doctor')->first();
        $role->syncPermissions($createdPermissions);
    }
    public static function createRecepcionistPermissions()
    {
        $permissions = [
            [
                'name'       => 'schedule_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'show_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'update_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'delete_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'attach_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
        ];

        $createdPermissions = [];

        foreach ($permissions as $permission) {
            if (Permission::whereName($permission['name'])->first() == null) {
                self::createPermission($permission);
                array_push($createdPermissions, $permission['name']);
            } else {
                array_push($createdPermissions, $permission['name']);
            }
        }

        $role = Role::where('name', 'recepcionist')->first();
        $role->syncPermissions($createdPermissions);
    }
    public static function createAdminPermissions()
    {
        $permissions = [
            [
                'name'       => 'attendants',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'doctors',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'recepcionists',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'schedule_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'show_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'update_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'delete_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],
            [
                'name'       => 'attach_appointments',
                'guard_name' => 'api',
                'created_at' =>  Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ],

        ];

        $createdPermissions = [];

        foreach ($permissions as $permission) {
            if (Permission::whereName($permission['name'])->first() == null) {
                self::createPermission($permission);
                array_push($createdPermissions, $permission['name']);
            } else {
                array_push($createdPermissions, $permission['name']);
            }
        }

        $role = Role::where('name', 'admin')->first();
        $role->syncPermissions($createdPermissions);
    }
    public static function createPermission(array $permission): Permission
    {
        return Permission::firstOrCreate($permission);
    }
}
