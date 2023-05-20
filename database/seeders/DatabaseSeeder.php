<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Author;
use App\Models\Source;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $authors = [
            ['name' => 'Author 1'],
            ['name' => 'Author 2'],
            ['name' => 'Author 3'],
            ['name' => 'Author 4'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }




        $sources = [
            ['name' => 'Barron'],
            ['name' => 'TweakTown'],
            ['name' => 'Business Insider'],
            ['name' => 'Pikabu.ru'],
        ];

        foreach ($sources as $source) {
            Source::create($source);
        }


        $categories = [
            ['name' => 'sports'],
            ['name' => 'Category 2'],
            ['name' => 'Category 3'],
            ['name' => 'Category 4'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }


        // $this->call(AuthorsSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
