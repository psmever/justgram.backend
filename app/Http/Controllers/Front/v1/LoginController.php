<?php

namespace App\Http\Controllers\Front\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('front.v1.login');
    }
}
