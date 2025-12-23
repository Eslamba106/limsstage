<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(PermissionSeeder::class);
        // Tenant::all()->runForEach(function () {
        //     User::factory()->create();
        // });
        //   \App\Models\Admin::create([
        //     'name' => 'Eslam',
        //     'user_name' => 'admin',
        //     'password' => Hash::make('12345'),
            
        // ]);
    }
}
