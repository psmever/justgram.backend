<?php

namespace App\Mail\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailMaster extends Mailable
{
    use Queueable, SerializesModels;

    public $Email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->Email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    if($this->Email->category == "user_email_auth")
	    {
	    	return $this->user_email_auth();
	    }
    }

    private function user_email_auth()
    {
	    return $this->from('psmever.sub@gmail.com')
		    ->subject('이메일 인증을 해주세요.')
		    ->view('mails.email_auth')
//		    ->text('mails.email_auth_plain')
		    ->with(
			    [
				    'testValue' => 'test',
			    ]);
    }


//	    return $this->from('psmever.sub@gmail.com')
//		    ->subject('Hello there!')
//		    ->view('mails.email_auth')
//		    ->text('mails.email_auth_plain')
//		    ->with(
//			    [
//				    'testVarOne' => 'testVarOne',
//				    'testVarTwo' => 'testVarTwo',
//			    ]);
//		    ->attach(public_path('/images').'/demo.jpg', [
//			    'as' => 'demo.jpg',
//			    'mime' => 'image/jpeg',
//		    ]);

}
