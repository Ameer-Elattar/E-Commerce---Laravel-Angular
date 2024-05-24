<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
             CartSeeder::class,
        ]);


    Product::factory(10)->create();

    Product::create([
    'title' => 'Chair',
    'description' => 'Good for buy',
    'price' => 19.99,
    'image' => 'product-3.png',
    'stock' => 2,
],[
    'title' => 'Table',
    'description' => 'Good for buy',
    'price' => 19.99,
    'image' => 'product-4.png',
    'stock' => 3,
],
[
    'title' => 'bed',
    'description' => 'Good for buy',
    'price' => 19.99,
    'image' => 'product-5.png',
    'stock' => 4,
],

);

$this->call(AdminSeeder::class);
    }
}
