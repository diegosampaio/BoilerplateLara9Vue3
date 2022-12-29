<?php

namespace Database\Seeders;

use Database\Factories\BooksFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fact = new BooksFactory();
        $fact->count(1000)
            ->create();
    }
}
