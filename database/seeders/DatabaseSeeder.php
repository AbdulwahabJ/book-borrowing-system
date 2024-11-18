<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // i didn't separate the roles and permissions into multiple files..
        //because I didn't use many roles and permissions.
        // Therefore, I kept them in a single file for simplicity.

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        Permission::firstOrCreate(['name' => 'managing-books']);
        Permission::firstOrCreate(['name' => 'view-books']);


        $adminRole->givePermissionTo(['managing-books', 'view-books']);
        $userRole->givePermissionTo(['view-books']);


        $adminUser = User::firstOrCreate([
            'name' => 'Admin ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Aa123456')
        ]);

        $normalUser = User::firstOrCreate([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('Aa123456')
        ]);

        $adminUser->assignRole('admin');
        $normalUser->assignRole('user');
    }
}
