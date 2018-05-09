<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
/**
 * @throws
 * */
function mobile ( ){
    return [135, 134, 187][random_int(0, 2)].sprintf('%08d', random_int(10000000, 100000000));
}
$factory->define(\App\Entities\User::class, function (Faker\Generator $faker) {
    $mobile = mobile();
    return [
        'mobile' => $mobile,
        'sex'    => ['UNKNOWN', 'MALE', 'FEMALE'][random_int(0, 2)],
        'nickname' => $faker->name,
        'user_name' => $faker->userName,
        'password' => \Illuminate\Support\Facades\Hash::make(md5($mobile.config('app.public_key')), [
            'slat' => config('app.private_key')
        ]),
    ];
});

$factory->define(\App\Entities\Role::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->name,
        'display_name' => $faker->userName
    ];
});

$factory->define(\App\Entities\Group::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->uuid,
        'display_name' => $faker->name
    ];
});


$factory->define(\App\Entities\Country::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->uuid,
        'name' => $faker->name
    ];
});

$factory->define(\App\Entities\Province::class, function (Faker\Generator $faker) {
    return [
        'country_id' => $faker->uuid,
        'code' => $faker->uuid,
        'name' => $faker->name
    ];
});

$factory->define(\App\Entities\City::class, function (Faker\Generator $faker) {
    return [
        'country_id' => $faker->uuid,
        'province_id' => $faker->uuid,
        'code' => $faker->uuid,
        'name' => $faker->name
    ];
});


$factory->define(\App\Entities\County::class, function (Faker\Generator $faker) {
    return [
        'country_id' => $faker->uuid,
        'province_id' => $faker->uuid,
        'city_id' => $faker->uuid,
        'code' => $faker->uuid,
        'name' => $faker->name
    ];
});