<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait OauthTrait {

    /**
     * 신규 토큰 발행.
     *
     * @param string $email
     * @param string $password
     * @return void
     */
    public function getNewToken(string $email, string $password) {

        $client = DB::table('oauth_clients')->where('password_client', true)->first();

        $dataObject = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ];

        $tokenRequest = Request::create('/api/v1/oauth/token', 'POST', $dataObject);
        $tokenRequestResult = json_decode(app()->handle($tokenRequest)->getContent());

        if(isset($tokenRequestResult->error_message) && $tokenRequestResult->error_message) {
            throw new \App\Exceptions\CustomException($tokenRequestResult->error_message);
        }

        return [
            'token_type' => $tokenRequestResult->token_type,
            'expires_in' => $tokenRequestResult->expires_in,
            'access_token' => $tokenRequestResult->access_token,
            'refresh_token' => $tokenRequestResult->refresh_token
        ];
    }

    /**
     * 토큰 리프레쉬.
     *
     * @param string $refresh_token
     * @return void
     */
    public function getRefreshToken(string $refresh_token) {

        $client = DB::table('oauth_clients')->where('password_client', true)->first();

        $dataObject = [
            'grant_type' => 'refresh_token',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'refresh_token' => $refresh_token,
            'scope' => '',
        ];

        $tokenRequest = Request::create('/api/v1/oauth/token', 'POST', $dataObject);
        $tokenRequestResult = json_decode(app()->handle($tokenRequest)->getContent());

        if(isset($tokenRequestResult->error_message) && $tokenRequestResult->error_message) {
            throw new \App\Exceptions\CustomException($tokenRequestResult->error_message);
        }

        return [
            'token_type' => $tokenRequestResult->token_type,
            'expires_in' => $tokenRequestResult->expires_in,
            'access_token' => $tokenRequestResult->access_token,
            'refresh_token' => $tokenRequestResult->refresh_token
        ];
    }
}
