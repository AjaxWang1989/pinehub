<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call('RolesTableSeeder');
         $this->call('CountriesTableSeeder');
         $this->call('ProvincesTableSeeder');
         $this->call('CitiesTableSeeder');
         $this->call('CountiesTableSeeder');
         $this->call('UsersTableSeeder');
    }
}
