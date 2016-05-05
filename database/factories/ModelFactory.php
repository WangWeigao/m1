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
        'name'             => $faker->name,
        'filename'         => $faker->name . '.mid',
        'instrument_id'    => mt_rand(1, 2),
        'composer'         => $faker->name,
        'press_id'         => mt_rand(1, 2),
        'operator'         => mt_rand(2, 4),
        'onshelf'          => mt_rand(1, 2),
        'note_operator'    => mt_rand(2, 4),
        'note_content'     => $faker->text,
        'organizer_id'     => mt_rand(1, 2),
        'section_duration' => mt_rand(1, 5),
        'track'            => mt_rand(1, 3),
        'level'            => mt_rand(1, 10),
        'play_times'       => mt_rand(1, 20),
        'created_at'       => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai')
    ];
});

/**
 * 定义 robot_orders 表的模型工厂
 */
$factory->define(App\RobotOrder::class, function (Faker\Generator $faker) {
    return [
        'order_num'  => str_random(1) . mt_rand(2015, 2016) . mt_rand(1, 12) . mt_rand(1, 31) . mt_rand(0000, 9999),
        'user_id'    => mt_rand(465, 769),
        'pay_time'   => $faker->datetimeBetween('2016-05-05 00:00:01', '+10 days', 'Asia/ShangHai'),
        'type'       => mt_rand(1, 2),
        'channel'    => mt_rand(1, 3),
        'price'      => mt_rand(100, 500),
        'status'     => mt_rand(1, 3),
        'islocked'   => mt_rand(0, 1),
        'operator'   => mt_rand(2, 4),
        'notes'      => $faker->text,
        'created_at' => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai')
    ];
});

/**
 * 定义 user_actions 表的模型工厂
 */
$factory->define(App\UserAction::class, function (Faker\Generator $faker) {
    return [
        'user_id'    => mt_rand(465, 769),
        'action'     => $faker->name,
        'duration'   => mt_rand(60, 3600),
        'created_at' => $faker->dateTimeBetween('-1 year', 'now', 'Asia/ShangHai')
    ];
});

/**
 * 定义 practice 表的模型工厂
 */
$factory->define(App\Practice::class, function (Faker\Generator $faker) {
    return [
        'uid'            => 465,
        'music_id'       => mt_rand(431, 1424),
        'practice_time'  => mt_rand(60, 3600),
        'practice_date'  => $faker->dateTimeBetween('2016-5-5 00:00:00', 'now', 'Asia/ShangHai'),
        'midi_path'      => '/users/' . $faker->name . '.mid,'
                         . '/users/' . $faker->name . '.mid',
        'wav_path'       => '/users/' . $faker->name . '.wav',
        'expiration'     => $faker->dateTimeBetween('now', '+1 year', 'Asia/ShangHai'),
        'match_measures' => mt_rand(1, 10) . ',' . mt_rand(1, 10) . ',' . mt_rand(1, 10),
        'error_measures' => mt_rand(1, 10) . ',' . mt_rand(1, 10) . ',' . mt_rand(1, 10),
        'fast_measures'  => mt_rand(1, 10) . ',' . mt_rand(1, 10) . ',' . mt_rand(1, 10),
        'slow_measures'  => mt_rand(1, 10) . ',' . mt_rand(1, 10) . ',' . mt_rand(1, 10),
        'rating'         => mt_rand(1, 10)
    ];
});
