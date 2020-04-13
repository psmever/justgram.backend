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

    public function setUp(): void {
        parent::setUp();
        $this->defaultHeader = TestCase::getDefaultHeaders();
        // $this->artisan('migrate:refresh', ['--seed' => '', '--database' => 'testing'])->run();

        Artisan::call('migrate',['-vvv' => true]);
        Artisan::call('passport:install',['-vvv' => true]);
        Artisan::call('db:seed',['-vvv' => true]);

    }

    public function testRegisterAndLogin()
    {
        // 가입
        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/register', [
            "username" => "mingun78",
            "email" => "mingun78@naver.com",
            "password" => "1212",
            "confirm_password" => "1212"
        ]);
        if(!$response->assertStatus(200)) {
            $response->dump();
        }

        //로그인
        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/login', [
            "email" => "mingun78@naver.com",
            "password" => "1212"
        ]);
        $response->assertStatus(401);

        // $results = DB::table('tbl_users_master')->get()->toArray();
        // print_r($results);

        // $results = DB::table('tbl_email_auth_master')->get()->toArray();
        // print_r($results);

        //이메일 인증.
        $user = DB::table('tbl_email_auth_master')->where('id', '2')->select('auth_code')->first();
        $response = $this->get("/front/v1/auth/email_auth?code=".$user->auth_code);
        $response->assertStatus(200);

            //로그인
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/login', [
            "email" => "mingun78@naver.com",
            "password" => "1211"
        ]);

        // $response->dump();

        $response->assertStatus(401)->assertJson([
            'error_message' => __('auth.failed')
        ]);



        // 로그인
        $response = $this->withHeaders($this->defaultHeader)->json('POST', '/api/justgram/v1/login', [
            "email" => "mingun78@naver.com",
            "password" => "1212"
        ]);
        $response->assertStatus(200);

        $token_type = $response['token_type'];
        $expires_in = $response['expires_in'];
        $access_token = $response['access_token'];
        $refresh_token = $response['refresh_token'];
        $user_name = $response['user_name'];
        $profile_active = $response['profile_active'];
        $profile_image_url = $response['profile_image_url'];

        $this->defaultHeader['Authorization'] = 'Bearer '.$access_token;

        // 리프레시 토큰 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/token/refresh', [
            "refresh_token" => "1".$refresh_token
        ]);

        $response->assertStatus(500)->assertJson([
            'error_message' => __('auth.bad_token')
        ]);

        // 리프레시 토큰 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/token/refresh', [
            "refresh_token" => $refresh_token
        ]);
        $response->assertStatus(200);

        $access_token = $response['access_token'];
        $refresh_token = $response['refresh_token'];


        // 내 토큰 정보.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/my/token/info', []);
        $response->assertStatus(200);


        // 내 프로필
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/my/profile', []);
        $response->assertStatus(200);

        // 사용자 프로필 ( 프로필 이미지 없을때.)
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/profile', []);
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_image_data')
        ]);


        // 프로필 이미지 실패
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile/image', [
            // "public_id" => "justgram_image/gqgedyzmobpnadhnhkdz",
            "version" => "1582725646",
            "signature" => "7cc3ced8d153ced291e5b0bf837398bf7c4d2eea",
            "width" => "512",
            "height" => "342",
            "format" => "jpg",
            "resource_type" => "image",
            "created_at" => "2020-02-26T14:00:46Z",
            "tags" => "",
            "bytes" => "44891",
            "type" => "upload",
            "etag" => "d98ce8fb59d10bd3a0b5fbc9aa0dc50e",
            "placeholder" => "false",
            "url" => "http://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "secure_url" => "https://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "access_mode" => "public",
            "original_filename" => "unnamed"
        ]);
        $response->assertStatus(400);

        // 프로필 이미지 성공.
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile/image', [
            "public_id" => "justgram_image/gqgedyzmobpnadhnhkdz",
            "version" => "1582725646",
            "signature" => "7cc3ced8d153ced291e5b0bf837398bf7c4d2eea",
            "width" => "512",
            "height" => "342",
            "format" => "jpg",
            "resource_type" => "image",
            "created_at" => "2020-02-26T14:00:46Z",
            "tags" => "",
            "bytes" => "44891",
            "type" => "upload",
            "etag" => "d98ce8fb59d10bd3a0b5fbc9aa0dc50e",
            "placeholder" => "false",
            "url" => "http://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "secure_url" => "https://res.cloudinary.com/smcdnimg/image/upload/v1582725646/justgram_image/gqgedyzmobpnadhnhkdz.jpg",
            "access_mode" => "public",
            "original_filename" => "unnamed"
        ]);
        $response->assertStatus(200);

        // 사용자 프로필 데이터 없을떄.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/profile', []);
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_data')
        ]);


        // 프로필 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
                // "name" => "park sung min",
                "web_site" => "http://psmever.github.io",
                "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
                "phone_number" => "01011111111",
                "gender" => "A21010"
        ]);
        // $response->dump();
        $response->assertStatus(400);

        // 프로필 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
            "name" => "park sung min",
            // "web_site" => "http://psmever.github.io",
            "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
            "phone_number" => "01011111111",
            "gender" => "A21010"
        ]);
        $response->assertStatus(400);

        // 프로필 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
            "name" => "park sung min",
            "web_site" => "http://psmever.github.io",
            // "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
            "phone_number" => "01011111111",
            "gender" => "A21010"
        ]);
        $response->assertStatus(400);

        // 프로필 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
            "name" => "park sung min",
            "web_site" => "http://psmever.github.io",
            "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
            // "phone_number" => "01011111111",
            "gender" => "A21010"
        ]);
        $response->assertStatus(400);

        // 프로필 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
            "name" => "park sung min",
            "web_site" => "http://psmever.github.io",
            "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
            "phone_number" => "01011111111",
            // "gender" => "A21010"
        ]);
        $response->assertStatus(400);


        // 사용자 프로필 데이터 없을때.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/profile', []);
        $response->assertStatus(400)->assertJson([
            'error_message' => __('messages.exits.profile_data')
        ]);

        // 프로필 등록 테스트 성공.
        $response = $this->withHeaders($this->defaultHeader)->putjson('/api/justgram/v1/my/profile', [
            "name" => "park sung min",
            "web_site" => "http://psmever.github.io",
            "bio" => "귀하다고 생각하고 귀하게 여기면 귀하지 않은 것이 없고,↵↵하찮다고 생각하고 하찮게 여기면 하찮지 않은 것이 없다.↵↵예쁘다고 생각하고 자꾸 쳐다보면 예쁘지 않은 것이 없고,↵↵밉다고 생각하고 고개 돌리면 밉지 않은 것이 없다.",
            "phone_number" => "01011111111",
            "gender" => "A21010"
        ]);
        $response->assertStatus(200);

        // 사용자 프로필 데이터 있을때.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/profile', []);
        $response->assertStatus(200);




        // 글 등록 안했을떄.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/post', []);
        $response->assertStatus(400);


        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                // "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);


        // 글 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post', [
            // "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                // "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);

        // 글 등록 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post', [
            // "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                // "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                // "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(400);


        // 글 등록 테스트 성공.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post', [
            "upload_image" => "{\"public_id\":\"justgram_image/oqhxs8coba8onqjg3vvx\",\"version\":1584885668,\"signature\":\"0e77a145ddfeb92c089fa552d8183372a29b1b40\",\"width\":512,\"height\":384,\"format\":\"jpg\",\"resource_type\":\"image\",\"created_at\":\"2020-03-22T14:01:08Z\",\"tags\":[],\"bytes\":74346,\"type\":\"upload\",\"etag\":\"2a4d2aeaef6c364154dc0a01a5893230\",\"placeholder\":false,\"url\":\"http://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"secure_url\":\"https://res.cloudinary.com/smcdnimg/image/upload/v1584885668/justgram_image/oqhxs8coba8onqjg3vvx.jpg\",\"access_mode\":\"public\",\"original_filename\":\"unnamed (1)\"}",
                "tags" => "[\"asdasd\",\"asdasd\",\"asdasd\",\"asdasd\"]",
                "contents" => "asdasdasd\nasd\nasd\nas\nd\nasd\n"
        ]);
        $response->assertStatus(200);


        // 등록한 글 리스트.
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/post', []);
        $response->assertStatus(200);



        // 코멘트 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/comment', [
            // "post_id" => 1,
            // "contents" => "asdasd\nasdasdasd\n"
        ]);
        $response->assertStatus(400);

        // 코멘트 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/comment', [
            "post_id" => 1,
            // "contents" => "asdasd\nasdasdasd\n"
        ]);
        $response->assertStatus(400);

        // 코멘트 테스트
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/comment', [
            // "post_id" => 1,
            "contents" => "asdasd\nasdasdasd\n"
        ]);
        $response->assertStatus(400);

        // 코멘트 테스트 성공.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/comment', [
            "post_id" => 1,
            "contents" => "asdasd\nasdasdasd\n"
        ]);
        $response->assertStatus(200);


        // 하트 주기.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/heart', [
            // "post_id" => 1,
        ]);
        $response->assertStatus(400);

        // 하트 주기 없는 포스트 일때.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/heart', [
            "post_id" => 4,
        ]);
        $response->assertStatus(400);


        // 하트 주기.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/post/heart', [
            "post_id" => 1,
        ]);
        $response->assertStatus(200);


        // 하트 취소.
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/post/heart', [
            // "post_id" => 1,
        ]);
        $response->assertStatus(400);

        // 하트 취소.
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/post/heart', [
            "post_id" => 100,
        ]);
        $response->assertStatus(400);


        // 하트 취소.
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/post/heart', [
            "post_id" => 1,
        ]);
        $response->assertStatus(200);


        // follow 추가 값 없을때.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/user/follow', [
            // "target_user_id" => 1,
        ]);
        $response->assertStatus(400);

        // follow 추가 없는사용자.
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/user/follow', [
            "target_user_id" => 100,
        ]);
        $response->assertStatus(400);

        // follow 추가
        $response = $this->withHeaders($this->defaultHeader)->postjson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(200);


        // follow 삭제 값 없을때.
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/user/follow', [
            // "target_user_id" => 1,
        ]);
        $response->assertStatus(400);

        // follow 삭제
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/user/follow', [
            "target_user_id" => 100,
        ]);
        $response->assertStatus(400);

        // follow 삭제
        $response = $this->withHeaders($this->defaultHeader)->deletejson('/api/justgram/v1/user/follow', [
            "target_user_id" => 1,
        ]);
        $response->assertStatus(200);


        // following 리스트
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/following');

        $response->assertStatus(200);

        // followers 리스트
        $response = $this->withHeaders($this->defaultHeader)->getjson('/api/justgram/v1/user/mingun78/followers');
        $response->assertStatus(200);

    }
}
