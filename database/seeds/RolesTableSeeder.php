<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Entities\Group::class, 1)->create([
            'code' => 'PH-'.sprintf('%06d', 1),
            'display_name' => '系统管理',
        ]);
        foreach ([[
            'slug' => 'super.administer',
            'display_name' => '系统超级管理员',
            'group_id' => 1
        ],[
            'slug' => 'sys.administer',
            'display_name' => '系统管理员',
            'group_id' => 1
        ],[
            'slug' => 'developer.administer',
            'display_name' => '系统开发人员',
            'group_id' => 1
        ],[
            'slug' => 'tester.administer',
            'display_name' => '系统测试员',
            'group_id' => 1
        ],[
            'slug' => 'customer',
            'display_name' => '客户'
        ],[
            'slug' => 'member' ,
            'display_name' => '会员'
        ],[
            'slug' => 'stranger',
            'display_name' => '访客'
        ],[
            'slug' => 'app.owner',
            'display_name' => '应用拥有者'
        ],[
            'slug' => 'seller',
            'display_name' => '分销员'
        ], [
            'slug' => 'shop.manager',
            'display_name' => '店铺经营者'
        ]] as $item){
            factory(\App\Entities\Role::class, 1)->create($item);
        }

    }
}
