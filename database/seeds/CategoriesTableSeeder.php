<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $virtual = Category::newQuery()->create([
            'name' => '虚拟产品',
            'parent_id' => 0,
            'app_id' => 'kdy5ccd661e38a97',
            'key' => Category::KEY_VIRTUAL
        ]);
        $deposit = Category::newQuery()->create([
            'name' => '储值卡',
            'parent_id' => $virtual->id,
            'app_id' => 'kdy5ccd661e38a97',
            'key' => Category::KEY_DEPOSIT_CARD
        ]);
        $discount = Category::newQuery()->create([
            'name' => '折扣卡',
            'parent_id' => $virtual->id,
            'app_id' => 'kdy5ccd661e38a97',
            'key' => Category::KEY_DISCOUNT_CARD
        ]);
        $deposit->children()->createMany([
            [
                'name' => '全类储值卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DEPOSIT_CARD_GENERAL
            ],
            [
                'name' => '用户储值卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DEPOSIT_CARD_USER
            ],
            [
                'name' => '商户储值卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DEPOSIT_CARD_MERCHANT
            ]
        ]);
        $discount->children()->createMany([
            [
                'name' => '全类折扣卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DISCOUNT_CARD_GENERAL
            ],
            [
                'name' => '用户折扣卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DISCOUNT_CARD_USER
            ],
            [
                'name' => '商户折扣卡',
                'app_id' => 'kdy5ccd661e38a97',
                'key' => Category::KEY_DISCOUNT_CARD_MERCHANT
            ]
        ]);
    }
}
