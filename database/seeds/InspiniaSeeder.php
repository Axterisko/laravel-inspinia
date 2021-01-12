<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InspiniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        Role::all()->each->delete();
        Role::truncate();
        DB::statement("SET foreign_key_checks=1");

        // create permissions
        $permissions = config('inspinia.permissions');
        foreach ($permissions as $permission => $roles)
            Permission::create(['name' => $permission]);

        // create roles
        $roles = config('inspinia.roles');
        foreach ($roles as $role):
            $role = Role::create(['name' => $role]);
            $role_permissions = [];
            foreach ($permissions as $permission => $roles):
                if (in_array($role->name, $roles)):
                    array_push($role_permissions, $permission);
                endif;
            endforeach;
            if($role_permissions) $role->givePermissionTo($role_permissions);
        endforeach;

        $role = Role::create(['name' => 'Administrators']);
        $role->givePermissionTo(array_keys($permissions));


        $admin = config('inspinia.admin');

        $userModel = config('inspinia.user');
        if (!$user = $userModel::where('username', $admin['username'])->first()) {
            $user = $userModel::create(array_merge($admin,[
                'name' => 'Admin',
                'password' => bcrypt($admin['username']),
            ]));

        }
        $user->assignRole('Administrators');

    }
}
