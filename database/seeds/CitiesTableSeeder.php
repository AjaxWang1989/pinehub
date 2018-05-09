<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $country = app(\App\Repositories\CountryRepositoryEloquent::class)->findWhere([ 'code' => '0086'])->first();
        $province = app(\App\Repositories\ProvinceRepositoryEloquent::class)->findWhere([ 'code' => '340000'])->first();
        factory(\App\Entities\City::class)->create([
            'country_id' => $country->id,
            'province_id' => $province->id,
            'code' => '340100',
            'name' => '合肥市'
        ]);
    }
}
