<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\JustGram\CloudinaryImageMaster;
use Faker\Generator as Faker;

$factory->define('App\Models\JustGram\CloudinaryImageMaster', function (Faker $faker) {
    return [
        'user_id' => 1,
        'image_category' => USER_PROFILE_IMAGE,
        "public_id" => "justgram_image/gqgedyzmobpnadhnhkdz",
        "version" => "1582725646",
        "signature" => "7cc3ced8d153ced291e5b0bf837398bf7c4d2eea",
        "width" => "512",
        "height" => "342",
        "format" => "jpg",
        "server_time" => "2020-02-26T14:00:46Z",
        "bytes" => "44891",
        "url" => "http://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
        "secure_url" => "https://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
        "original_filename" => "unnamed"
    ];
});
