<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Route;

trait OauthTrait {

    /**
     * 신규 토큰 발행.
     *
     * @param string $email
     * @param string $password
     * @return void
     */
    public static function getNewToken(string $email, string $password) {

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
    public static function getRefreshToken(string $refresh_token) {

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

        // print_r($tokenRequestResult);

        if(isset($tokenRequestResult->error) && $tokenRequestResult->error) {
            throw new \App\Exceptions\CustomException(__('auth.bad_token'));
        }

        return [
            'token_type' => $tokenRequestResult->token_type,
            'expires_in' => $tokenRequestResult->expires_in,
            'access_token' => $tokenRequestResult->access_token,
            'refresh_token' => $tokenRequestResult->refresh_token
        ];
    }

    /**
     * router 에서 auth:api 우회 했을때 토큰은 확인 가능하지만 Auth:id() 가 안먹혀서
     * 강제로 하나 만듬.
     *
     * @param [type] $request
     * @return void
     */
    public static function getUserInfoByBearerToken ($request)
    {
        if(!$request->headers->get('authorization') || !$request->headers->get('request-client-type')) {
            return false;
        }

        $client = Request::create('/api/justgram/v1/my/token/info', 'GET');

        $client->headers->set('Request-Client-Type', $request->headers->get('request-client-type'));
        $client->headers->set('Accept', $request->headers->get('accept'));
        $client->headers->set('Content-Type', $request->headers->get('content-type'));
        $client->headers->set('Authorization', $request->headers->get('authorization'));

        $taskResult = app()->handle($client);

        if($taskResult->status() !== 200) {
            return false;
        }

        return json_decode($taskResult->getContent());
    }
}
