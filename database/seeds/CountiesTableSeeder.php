<?php

use Illuminate\Database\Seeder;

class CountiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//340102	    瑶海区
//340103	    庐阳区
//340104	    蜀山区
//340111	    包河区
//340121	    长丰县
//340122	    肥东县
//340123	    肥西县
//340124	    庐江县
//340181	    巢湖市
        $country = app(\App\Repositories\CountryRepositoryEloquent::class)->findWhere([ 'code' => '0086'])->first();
        $province = app(\App\Repositories\ProvinceRepositoryEloquent::class)->findWhere([ 'code' => '340000'])->first();
        $city = app(\App\Repositories\CityRepositoryEloquent::class)->findWhere([ 'code' => '340100'])->first();
        foreach ([
            [
                'code' => '340102',
                'name' => '瑶海区'
            ], [
                'code' => '340103',
                'name' => '庐阳区'
            ], [
                'code' => '340104',
                'name' => '蜀山区'
            ], [
                'code' => '340111',
                'name' => '包河区'
            ], [
                 'code' => '340121',
                 'name' => '长丰县'
            ], [
                'code' => '340122',
                'name' => '肥东县'
            ], [
                'code' => '340123',
                'name' => '肥西县'
            ],  [
                'code' => '340124',
                'name' => '庐江县'
            ], [
                'code' => '340181',
                'name' => '巢湖市'
            ]] as $item){
            factory(\App\Entities\County::class)->create([
                'country_id' => $country->id,
                'province_id' => $province->id,
                'city_id'   => $city->id,
                'code' => $item['code'],
                'name' => $item['name']
            ]);
        }

    }
}
