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
		$auth_code = "IpgQbNdZEAo1hhn0V7fhxFXrFo2RYkmB3rdtlWfzcw3Du9MutCPPebBrySaKsx9lE0VL9mAnWu6jbhtA";

		$emailObject = new \stdClass();
		$emailObject->category = "user_email_auth";
		$emailObject->receiverName = "psmever";
		$emailObject->receiver = "psmever@gmail.com";
		$emailObject->auth_code = $auth_code;
		$emailObject->auth_url = url('/front/v1/auth/email_auth?code='.$auth_code);

		Mail::to("psmever@gmail.com")->send(new EmailMaster($emailObject));

	}

    public function test_mail()
    {

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
