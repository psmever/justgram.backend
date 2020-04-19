<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define('App\Models\JustGram\UserProfiles', function (Faker $faker) {
    return [
        "name" => $this->faker->name,
        "web_site" => $this->faker->url,
        "bio" => $this->faker->text,
        "phone_number" => $this->faker->phoneNumber,
        "gender" => "A21010"
    ];
});
