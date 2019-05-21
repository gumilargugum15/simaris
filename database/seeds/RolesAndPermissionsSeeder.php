<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit risiko']);
        Permission::create(['name' => 'delete risiko']);
        Permission::create(['name' => 'add risiko']);
        Permission::create(['name' => 'validasi risiko']);
        Permission::create(['name' => 'kaidah risiko']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'keyperson']);
        $role->givePermissionTo(['add risiko','edit risiko','delete risiko','validasi risiko']);

        // or may be done by chaining
        $role = Role::create(['name' => 'verifikatur'])
            ->givePermissionTo(['validasi risiko', 'kaidah risiko']);
        $role = Role::create(['name' => 'pimpinanunit'])
            ->givePermissionTo(['validasi risiko']);
        $role = Role::create(['name' => 'managergcg'])
            ->givePermissionTo(['validasi risiko']);

        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo(Permission::all());
    }
}
