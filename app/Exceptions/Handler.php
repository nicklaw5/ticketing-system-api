<?php

namespace App\Exceptions;

use Exception;

// STRYVE EXCEPTIONS
use Stryve\Exceptions\Http\HttpNotFoundExeption;
use Stryve\Exceptions\Http\HttpBadRequestExeption;

// LARVEL EXCEPTIONS
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // LARAVEL EXCEPTIONS
        if ($e instanceof ModelNotFoundException)
            $e = new NotFoundHttpException($e->getMessage(), $e);

        // STRYVE EXCEPTIONS
        if ($e instanceof HttpBadRequestExeption) 
            return $this->api->respondBadRequest($e->getMessage(), $e->getCode());

        if ($e instanceof HttpNotFoundExeption)
            return $this->api->respondBadRequest($e->getMessage(), $e->getCode());

        return parent::render($request, $e);
    }
}
