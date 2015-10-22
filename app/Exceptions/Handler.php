<?php

namespace App\Exceptions;

use Exception;

// STRYVE EXCEPTIONS
use Stryve\Exceptions\MyCustomException;
use Stryve\Exceptions\HttpBadRequestExeption;

// LARVEL EXCEPTIONS
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    // protected $api;

    // public function __construct(LoggerInterface $log, ApiResponses $api)
    // {
    //     parent::__construct($log);
    //     $this->api = $api;

    // }

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
        if ($e instanceof ModelNotFoundException)
            $e = new NotFoundHttpException($e->getMessage(), $e);

        if ($e instanceof HttpBadRequestExeption)
            return $this->api->respondBadRequest();

        return parent::render($request, $e);
    }
}
