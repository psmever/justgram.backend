<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function defaultError()
    {
	    return response()->view('errors.500', [], 500);
    }
}
