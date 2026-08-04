<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = config('roles.permissions', []);
        $defaults = config('roles.defaults', []);

        $permissionIds = [];
        foreach ($catalog as $module => $permissions) {
            foreach ($permissions as $name => $label) {
                $permission = Permission::updateOrCreate(
                    ['name' => $name],
                    ['label' => $label, 'module' => $module]
                );
                $permissionIds[$name] = $permission->id;
            }
        }

        foreach ($defaults as $name => $granted) {
            $role = Role::updateOrCreate(
                ['name' => $name],
                ['label' => $name, 'description' => null]
            );

            if ($name === 'Administrator') {
                $role->permissions()->sync(array_values($permissionIds));
            } else {
                $grantedIds = array_values(array_intersect_key($permissionIds, array_flip($granted)));
                $role->permissions()->sync($grantedIds);
            }
        }
    }
}
