<?php

namespace Database\Seeders;
use Database\Factories;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::factory(20)->create();
        // factory(\App\Models\Product::class , 10)->create();

    }
}