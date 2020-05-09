<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    const HTTP_UNPROCESSABLE_ENTITY = 422;
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
         if ($request->is('api/*')) {
            return $this->handleAPIExceptions($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param $request
     * @param $exception
     *
     * @return \Illuminate\Http\Response|mixed
     */
    private function handleAPIExceptions($request, $exception)
    {

        if ($exception instanceof HttpException) {
            return $this->respondWithError(JsonResponse::$statusTexts[$exception->getStatusCode()], $exception->getStatusCode());
        } else if ($exception instanceof ValidationException) {
            $error = collect($exception->validator->errors()->getMessages());
            return $this->respondWithError($error, self::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $exception);
    }

    /**
     * Respond with a generic error
     *
     * @param string $message
     * @param $status_code
     *
     * @return mixed
     */
    public function respondWithError($message, $status_code)
    {
        return response()->json([
                'error' => true,
                'message' => $message,
                'status_code' => $status_code
        ], $status_code);
    }
}
