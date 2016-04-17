<?php

use App\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create(array(
            'code' => 'SUU',
            'name' => 'Suunnittelu',
            'description' => 'Suunnittelu'
        ));
        State::create(array(
            'code' => 'TOT',
            'name' => 'Toteutus',
            'description' => 'Toteutus'
        ));
        State::create(array(
            'code' => 'VAL',
            'name' => 'Projekti valmis',
            'description' => 'Projekti valmis'
        ));
    }
}
