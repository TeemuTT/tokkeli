<?php

use App\State;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Category::create(array(
            'code' => 'DOK',
            'name' => 'Dokumentointi',
            'description' => 'Projektin dokumentointi'
        ));
        App\Category::create(array(
            'code' => 'OHJ',
            'name' => 'Ohjelmointi',
            'description' => 'Ohjelmointi'
        ));
        App\Category::create(array(
            'code' => 'MUU',
            'name' => 'Muu työ',
            'description' => 'Muu projektiin liittyvä työskentely'
        ));
    }
}
