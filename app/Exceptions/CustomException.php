<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
	/**
	 * Report the exception.
	 *
	 * @return void
	 */
	public function report()
	{
	}

	/**
	 * Render the exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, $exception)
	{
		return response()->json([
			'error_message' => $exception->getMessage(),
		], 500);

	}
}
