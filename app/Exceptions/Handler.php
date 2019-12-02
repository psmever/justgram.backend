<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // TODO : Exception DontReport
	    \Illuminate\Auth\AuthenticationException::class,
	    \Illuminate\Auth\Access\AuthorizationException::class,
	    \Symfony\Component\HttpKernel\Exception\HttpException::class,
	    \Illuminate\Database\Eloquent\ModelNotFoundException::class,
	    \Illuminate\Session\TokenMismatchException::class,
	    \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

	    $logid = date('Ymdhis'); // 로그 고유값.

    	//TODO: Exception Control
	    if ($exception instanceof \PDOException)  // mysql Exception 따로 기록.
	    {
			$logMessage = "ID:{$logid} Code:{$exception->getCode()} Message:{$exception->getMessage()} File:{$exception->getFile()} Line:{$exception->getLine()}";
			Log::channel('pdoexceptionlog')->error($logMessage);

	    }
	    else if ($exception instanceof \App\Exceptions\CustomException) // 기타 Exception
	    {
		    return $exception->render($request, $exception);
	    }

	    if ($this->isHttpException($exception)) {  // 일 반 웹 요청 일떄.

		    if (view()->exists('errors.'.$exception->getStatusCode($exception)))
		    {
			    return response()->view('errors.'.$exception->getStatusCode($exception), [
			    	'message' => config('app.debug') ? $exception->getMessage() : ''
			    ], $exception->getStatusCode($exception));
		    }

		    return response()->view('errors.500', [
			    'message' => config('app.debug') ? $exception->getMessage() : ''
		    ], 500);
	    }
	    else
	    {
	    	// ajax 요청 일떄.
		    if(config('app.debug'))
		    {
			    return response()->json([
				    'error' => 'Exception Error.',
				    'error_class' => get_class($exception),
				    'error_message' => $exception->getMessage(),
			    ], 500);
		    }
		    else
		    {
			    return response()->json([
				    'error' => 'Server Error',
			    ], 500);
		    }
	    }

	    return parent::render($request, $exception);
    }
}
