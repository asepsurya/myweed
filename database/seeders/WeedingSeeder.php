<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WeedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Roles
        $admin = Role::create(['name' => 'admin']);
        $planner = Role::create(['name' => 'wedding-planner']);
        $guest = Role::create(['name' => 'guest']);
        $guest = Role::create(['name' => 'user']);

        // Permissions
        $permissions = [
            'manage-users',
            'edit-theme',
            'manage-gallery',
            'manage-music',
            'manage-rsvp',
            'view-invitation'
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Assign permission ke role
        $admin->givePermissionTo(Permission::all()); // admin dapat semua
        $planner->givePermissionTo(['manage-gallery','manage-music','manage-rsvp','edit-theme']);
        $guest->givePermissionTo(['view-invitation']);
    }
}
