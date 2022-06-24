<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-statuses']);
        Permission::create(['name' => 'edit-statuses']);
        Permission::create(['name' => 'delete-statuses']);

        Permission::create(['name' => 'create-customer-informations']);
        Permission::create(['name' => 'edit-customer-informations']);
        Permission::create(['name' => 'delete-customer-informations']);

        Permission::create(['name' => 'create-addresses']);
        Permission::create(['name' => 'edit-addresses']);
        Permission::create(['name' => 'delete-addresses']);

        Permission::create(['name' => 'create-payment-methods']);
        Permission::create(['name' => 'edit-payment-methods']);
        Permission::create(['name' => 'delete-payment-methods']);

        Permission::create(['name' => 'create-categories']);
        Permission::create(['name' => 'edit-categories']);
        Permission::create(['name' => 'delete-categories']);

        $adminRole = Role::create(['name' => 'Admin']);
        $editorRole = Role::create(['name' => 'Editor']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-statuses',
            'edit-statuses',
            'delete-statuses',
            'create-customer-informations',
            'edit-customer-informations',
            'delete-customer-informations',
            'create-addresses',
            'edit-addresses',
            'delete-addresses',
            'create-payment-methods',
            'edit-payment-methods',
            'delete-payment-methods',
            'create-categories',
            'edit-categories',
            'delete-categories',
        ]);

        $editorRole->givePermissionTo([
            'create-statuses',
            'edit-statuses',
            'delete-statuses',
            'create-customer-informations',
            'edit-customer-informations',
            'delete-customer-informations',
            'create-categories',
            'edit-categories',
            'delete-categories',
            'create-payment-methods',
            'edit-payment-methods',
            'delete-payment-methods',
        ]);
    }
}
