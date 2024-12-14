<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete all media files

        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $user = User::factory()->create([
            'name' => 'Boris Strahija',
            'email' => 'bstrahija@gmail.com',
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);

        $user->assignRole('superadmin');
        $user->assignRole('admin');

        $this->call([
            GlobetkaSeeder::class,
        ]);
    }
}
