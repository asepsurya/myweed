<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WeddingDefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $guestRole = Role::firstOrCreate(['name' => 'user']);

        // Admin (1x)
        if (! User::where('email', 'admin@wedding.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin Wedding',
                'email' => 'admin@wedding.com',
                'role' => 'admin',
                'password' => Hash::make('password123'), // ganti sesuai kebutuhan
                'email_verified_at' => now(),
            ]);
            $admin->assignRole($adminRole);
        }

        // Guest/User (1x)
        if (! User::where('email', 'user@wedding.com')->exists()) {
            $guest = User::create([
                'name' => 'Tamu Undangan',
                'email' => 'user@wedding.com',
                'role' => 'user',
                'password' => Hash::make('password123'), // ganti sesuai kebutuhan
            ]);
            $guest->assignRole($guestRole);
        }

        $admin->givePermissionTo(Permission::all());
    }
}
