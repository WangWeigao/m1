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
 * 定义 users 表的模型工厂
 */
$factory->define(App\StudentUser::class, function (Faker\Generator $faker) {
    return [
        'cellphone'      => $faker->phoneNumber,
        'email'          => $faker->email,
        'password'       => bcrypt(str_random(10)),
        'nickname'       => $faker->name,
        'usertype'       => mt_rand(0, 1),
        // 'remember_token' => str_random(10),
        'lastlogin'      => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai'),
        'regdate'        => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai'),
        'isactive'       => mt_rand(0, 1),
        'channel'        => mt_rand(0, 1),
        'lastpractice'   => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai'),
        'serialday'      => mt_rand(0, 100),
        'age'            => mt_rand(3, 20),
        // 'sns_id' =>
        // 'access_token' =>
        'instrument_id'  => mt_rand(1, 2),
        'avatar'         => str_random(10) . '.png',
        'seq_num'        => str_random(1) . rand(2016010000, 2016129999),
        // 'province_id' =>
        'city_id'        => mt_rand(1, 33),
        'sex'            => mt_rand(1, 2),
        'study_age'      => mt_rand(3, 10),
        'user_grade'     => mt_rand(1, 10),
        'account_grade'  => mt_rand(1, 2),
        'account_end_at' => $faker->dateTimeBetween('now', '+1 year', 'Asia/ShangHai'),
        'account_status' => mt_rand(1, 3)
    ];
});

/**
 * 定义 musics 表的模型工厂
 */
$factory->define(App\Music::class, function (Faker\Generator $faker) {
    return [
        ''
    ];
});
