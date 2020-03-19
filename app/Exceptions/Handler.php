<?php

namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ErrorException::class,
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(
            [
                "status" => 0,
                "massege" => "دسترسی رد شد"
            ], 401);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                [
                    "status" => 0,
                    "massege" => "نوع درخواست نامعتبر می باشد."
                ], 200);
        }

        if ($exception instanceof ThrottleRequestsException) {
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        "status" => 0,
                        "massege" => "نوع درخواست نامعتبر می باشد."
                    ], 200);
            }
            return response()->json(
                [
                    "status" => 0,
                    "massege" => "تعداد درخواست های ارسالی شما بیش از حد مجاز می باشد، لطفا کمی صببر نمایید و مجدد درخواست ارسال نمایید"
                ], 200);
        }


        if($exception instanceof NotFoundHttpException){
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        "status" => 0,
                        "massege" => "امکان ارسال درخواست با این مشخصات وجود ندارد."
                    ], 200);
            }
        }

        if($exception instanceof AccessDeniedHttpException){
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        "status" => 0,
                        "massege" => "درخواست نامعتبر است."
                    ], 200);
            }
        }

        return parent::render($request, $exception);
    }
}
