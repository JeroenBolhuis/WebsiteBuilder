<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->createRoles();
        $this->createPermissions();
        $this->assignPermissionsToRoles();
        $this->createAdminUsers();
    }

    private function createRoles()
    {
        Role::create(['name' => 'administrator']);
        Role::create(['name' => 'editor']);
    }

    private function createPermissions()
    {
        Permission::create(['name' => 'edit page']);
        Permission::create(['name' => 'edit event']);
        Permission::create(['name' => 'edit nav']);
        Permission::create(['name' => 'edit media']);
        Permission::create(['name' => 'edit sponsor']);
        Permission::create(['name' => 'edit footer']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'edit post']);
        Permission::create(['name' => 'edit album']);
        Permission::create(['name' => 'see log']);
    }

    private function assignPermissionsToRoles()
    {
        $adminRole = Role::findByName('administrator');
        $adminPermissions = Permission::all();
        $adminRole->syncPermissions($adminPermissions);

        $editorRole = Role::findByName('editor');
        $editorPermissions = [
            'edit page',
            'edit event',
            'edit sponsor',
            'edit nav',
            'edit media',
            'edit footer',
            'edit album',
        ];
        $editorRole->givePermissionTo($editorPermissions);
    }

    private function createAdminUsers()
    {
        $admins = [
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@hetkoppel',
                'password' => Hash::make('Ab12345'),
            ]),
            User::create([
                'name' => 'Luuk',
                'email' => 'luuk@gmail.com',
                'password' => Hash::make('luuk@gmail.com'),
            ]),
        ];

        foreach ($admins as $admin) {
            $admin->syncPermissions(Permission::all());
        }
    }
}
