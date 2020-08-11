<?php

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws \ReflectionException
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();

        $permissions = Collection::make(Permissions::getConstants());

        $permissions->each(function ($permission) {
            Permission::firstOrCreate(['name' => $permission]);
        });

        $roles = Collection::make(Roles::getConstants());

        $roles->each(function ($role) {
            $role = Role::firstOrCreate(['name' => $role]);
            if ($role->name === Roles::ADMINISTRATOR) {
                $role->givePermissionTo(Permissions::INVITE_USERS);
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
