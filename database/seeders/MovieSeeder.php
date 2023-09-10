<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $faker = Factory::create();

        $count = 20;

        for ($i = 0; $i < $count; $i++) {
            DB::table('movies')->insert([
                'title' => $faker->title,
                'summary' => $faker->sentence(30),
                'cover_image' =>  '',
                'genres' => $faker->randomElement(['Action', 'Adventure', 'Comedy','Drama', 'Horror', 'Science Fiction','Fantasy', 'Thriller', 'Romance','Animation']),
                'author' => $faker->name,
                'tags' => 'tag-' . $i,
                'imdb_rating' => $i,
                'pdf_download_link' => $faker->title.'pdf',
                'created_at' => $faker->dateTime($max = 'now', $timezone = null),
                'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
            ]);
        }
    }
}
