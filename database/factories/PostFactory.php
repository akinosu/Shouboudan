<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'subject' => $faker->realText(16),    // 16文字のテキスト
        'message' => $faker->realText(200),    // 200文字のテキスト
        'city_id' => $faker->randomElement(['11002', '34835', '182109', '203076', '232017', '234273']),    // 引数の中からランダムな値を出力
        'user_id' => $faker->randomElement(['1','2','3','4']),
        'gender' => $faker->randomElement(['1','2','3']),
        'age' => $faker->randomElement(['21','29','32','46']),
        'immigrant' => $faker->randomElement(['0','1']),
        'start' => $faker->randomElement(['2001','2009','1994','1999']),
        'end' => $faker->randomElement(['2010','2019','2016','2020'])
    ];
});
