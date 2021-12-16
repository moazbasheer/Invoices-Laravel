<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\CreateAdminUserSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\SectionsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            SectionsTableSeeder::class,
            ProductsTableSeeder::class
        ]);
    }
}
