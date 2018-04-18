<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Entities\Country::class)->create([
            'code' => '0086',
            'name' => '中国'
        ]);
    }
}
