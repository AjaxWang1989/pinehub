<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
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
        factory(\App\Entities\Province::class)->create([
            'country_id' => $country->id,
            'code' => '340000',
            'name' => '安徽省'
        ]);
    }
}
