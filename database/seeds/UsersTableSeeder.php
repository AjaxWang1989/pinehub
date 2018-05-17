<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(\App\Entities\User::class, 50)->create()->map(function (\App\Entities\User $user){
            $user->roles()->attach(random_int(0, 100)%4 +1);
        });
    }
}
