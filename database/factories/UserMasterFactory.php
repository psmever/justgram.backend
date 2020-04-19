<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\MasterHelper;
use App\Model\JustGram\UsersMaster;
use Faker\Generator as Faker;

$factory->define('App\Models\JustGram\UsersMaster', function (Faker $faker) {
    return [
        'user_uuid' => MasterHelper::GenerateUUID(),
        'user_type' => 'A02001',
        'user_state' => 'A10010',
        'user_level' => 'A20000',
        'user_name' => MasterHelper::setUserName($faker->name),
        'email' => $faker->email,
        'password' => bcrypt('password'),
        'user_active' => 'Y',
        'email_verified_at' => date('Y-m-d H:i:s'),
        'created_at'  => date('Y-m-d H:i:s'),
        'updated_at'  => date('Y-m-d H:i:s')
    ];
});
