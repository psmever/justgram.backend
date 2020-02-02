<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\MasterHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\v1\EmailMaster;

use App\Models\JustGram\EmailAuth;

class TestController extends Controller
{
	public function test()
	{
		echo "client_id".env('PASSPORT_PASSWORD_GRANT_CLIENT_ID').PHP_EOL;
		echo "secret".env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET').PHP_EOL;
	}

    public function test_mail()
    {
        // 메일 테스트
	    $auth_code = Str::random(80);

	    EmailAuth::create([
		    'user_uuid' => 'ac5c8f12-8b92-40be-8606-03154eef626c',
		    'auth_code' => $auth_code,
	    ]);


	    $viewData = [
	    	'title' => "이메일을 인증해 주세요.",
	    	'auth_url' => url('/front/v1/auth/email_auth?code='.$auth_code)
	    ];

	    Mail::send('emails.email', $viewData, function($message) {
		    $message->to('psmever@gmail.com', 'psmever')
			    ->subject('이메일을 인증해 주세요.');
	    });
    }


}
