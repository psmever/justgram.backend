<?php

namespace Tests\Feature\user;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UsersTest extends TestCase
{
    protected $defaultHeader;

    public function setUp(): void{
        parent::setUp();
        $this->defaultHeader = TestCase::getDefaultHeaders();
        // $this->artisan('migrate', ['--seed' => '', '--database' => 'testing'])->run();

        Artisan::call('migrate',['-vvv' => true]);
        Artisan::call('passport:install',['-vvv' => true]);
        Artisan::call('db:seed',['-vvv' => true]);
    }

   public function testRegisterAndLogin()
   {
        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/register', [
            "username" => "mingun78",
            "email" => "mingun78@naver.com",
            "password" => "1212",
            "confirm_password" => "1212"
        ]);

        // $response->dumpHeaders();
        // $response->dump();
        $response->assertStatus(200);

        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/login', [
            "email" => "mingun78@naver.com",
            "password" => "1212"
        ]);

        // $response->dumpHeaders();
        // $response->dump();
        $response->assertStatus(401);

        // $results = DB::table('tbl_users_master')->get()->toArray();
        // print_r($results);

        // $results = DB::table('tbl_email_auth_master')->get()->toArray();
        // print_r($results);

        $user = DB::table('tbl_email_auth_master')->where('id', '2')->select('auth_code')->first();
        $response = $this->get("/front/v1/auth/email_auth?code=".$user->auth_code);

        // $response->dump();
        $response->assertStatus(200);


        // /front/v1/auth/email_auth?code=Jp1Z0yoPzmIeB1IXLeoVdexTgm7rpMxdc5EFtAg1TW3ZZ6pVRkbaB8oSXXRR7FPUP3EJRHwrt9lLg9q4


        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/login', [
            "email" => "mingun78@naver.com",
            "password" => "1212"
        ]);

        $response->assertStatus(200);
   }

}
