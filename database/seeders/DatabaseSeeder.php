<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name' => 'Fiction',
            'description' => 'Book genre about situations that are not real',
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Self-help',
            'description' => 'Book genre about ways to improve the self',
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Biography',
            'description' => 'Book genre about the description of the life of an important person',
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Chronicles',
            'description' => "Book genre to describe situations in the past according to someone's point of view",
        ]);

        DB::table('categories')->insert([
            'category_name' => 'History',
            'description' => 'Book genre about past events',
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Teen novels',
            'description' => 'Book genre about romance focused on teenagers',
        ]);
    }
}
