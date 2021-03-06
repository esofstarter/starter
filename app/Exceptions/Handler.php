<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        //
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if(\Config::get('app.display_errors_in_response'))
            return parent::render($request, $e);
        if ($e instanceof ValidationException && $request->ajax()) {
            return response()->json([
                'message' => __('validation.message'),
                'errors' => $e->validator->getMessageBag(),
            ], 422);
        }

        // Add dump of Request to found reason for exception
        $shouldReport = $this->shouldReport($e);
        if ($shouldReport) {
           Log::error('Dump request', array($request->__toString()));
        }

        if ($e instanceof QueryException && $request->wantsJson()) {
            return response()->json(error(
                'errors.fatal_error',
                'database'
            ), 422);
        }

        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['token_expired'], 401);
        } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(['token_invalid'], 401);
        }

        if ($e instanceof ModelNotFoundException){
            if(request()->segment(1) == 'api'){
                return response()->json([
                    'message' => 'Record not found'
                ], 404);
            }
        }

        return parent::render($request, $e);
    }
}
