<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team; // Add Team model
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Relations\HasMany;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Misc
        $miscPermission = Permission::create(['name' => 'N/A']);

        // USER MODEL
        $userPermissions = [
            Permission::create(['name' => 'create: user']),
            Permission::create(['name' => 'read: user']),
            Permission::create(['name' => 'update: user']),
            Permission::create(['name' => 'delete: user']),
        ];

        // ROLE MODEL
        $rolePermissions = [
            Permission::create(['name' => 'create: role']),
            Permission::create(['name' => 'read: role']),
            Permission::create(['name' => 'update: role']),
            Permission::create(['name' => 'delete: role']),
        ];

        // PERMISSION MODEL
        $permissionPermissions = [
            Permission::create(['name' => 'create: permission']),
            Permission::create(['name' => 'read: permission']),
            Permission::create(['name' => 'update: permission']),
            Permission::create(['name' => 'delete: permission']),
        ];

        // ADMINS
        $adminPermissions = [
            Permission::create(['name' => 'read: admin']),
            Permission::create(['name' => 'update: admin']),
        ];

        // CREATE ROLES
        $roles = [
            'user' => $userPermissions,
            'super-admin' => array_merge($userPermissions, $rolePermissions, $permissionPermissions, $adminPermissions),
            'admin' => array_merge($userPermissions, $rolePermissions, $permissionPermissions, $adminPermissions),
        ];

        // Create dummy team
        $dummyTeam = Team::create([
            'name' => 'Team',
            'slug' => 'team',
        ]);

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName])->syncPermissions($rolePermissions);
            if ($roleName === 'super-admin') {
                User::create([
                    'team_id' => $dummyTeam->id,
                    'name' => 'Super Admin',
                    'is_admin' => 1,
                    'email' => 'superadmin@admin.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                ])->assignRole($role);
                 } else if ($roleName === 'admin') {
                    User::create([
                        'team_id' => $dummyTeam->id,
                        'name' => 'Admin',
                        'is_admin' => 0,
                        'email' => 'admin@admin.com',
                        'email_verified_at' => now(),
                        'password' => Hash::make('password'),
                        'remember_token' => Str::random(10),
                    ])->assignRole($role);
            } else {
                User::create([
                    'team_id' => $dummyTeam->id,
                    'name' => 'User',
                    'is_admin' => 0,
                    'email' =>  'user@admin.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                ])->assignRole($role);
            }
        }
    }
}
