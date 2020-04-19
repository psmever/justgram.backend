<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TblCodesMasterTableSeeder'], ['--database' => 'sqlite_testing']);
        $this->artisan('passport:install');
    }

    protected function getUser()
    {
        return factory('App\Models\JustGram\UsersMaster')->create();
    }

    protected function setUserAndProfile($user)
    {
        factory('App\Models\JustGram\UserProfiles')->create();
        factory('App\Models\JustGram\CloudinaryImageMaster')->create();
        DB::table('tbl_users_master')->where('id', 1)->update(['profile_image' => 1]);
        return $user;
    }

    protected function printUsers()
    {
        $user = DB::table('tbl_email_auth_master')->get();
        dd($user);
    }

}
