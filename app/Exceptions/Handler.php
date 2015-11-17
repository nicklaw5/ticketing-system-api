<?php

namespace App\Exceptions;

use Larapi;
use Exception;

// STRYVE HTTP EXCEPTIONS
use Stryve\Exceptions\Http\HttpNotFoundException;
use Stryve\Exceptions\Http\HttpConflictException;
use Stryve\Exceptions\Http\HttpBadRequestException;
use Stryve\Exceptions\Http\HttpUnauthorizedException;

// STRYVE APP EXCEPTIONS
use Stryve\Exceptions\App\InvalidSubdomainException;
use Stryve\Exceptions\App\InvalidEmailAddressException;
use Stryve\Exceptions\App\AccountAlreadyExistsException;

// LARVEL EXCEPTIONS
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // HttpException::class,
        // ModelNotFoundException::class,
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
        /**********************/
        /* LARAVEL EXCEPTIONS */
        /**********************/
        if ($e instanceof ModelNotFoundException)
            return Larapi::respondNotFound($e->getMessage(), $e->getCode());

        if ($e instanceof MethodNotAllowedHttpException)
            return Larapi::respondMethodNotAllowed($e->getMessage(), $e->getCode());

        /**************************/
        /* STRYVE HTTP EXCEPTIONS */
        /**************************/
        if ($e instanceof HttpBadRequestException)
            return Larapi::respondBadRequest($e->getMessage(), $e->getCode());
                    
        if ($e instanceof HttpConflictException)
            return Larapi::respondConflict($e->getMessage(), $e->getCode());
        
        if ($e instanceof HttpUnauthorizedException)
            return Larapi::respondUnauthorized($e->getMessage(), $e->getCode());
        
        // /*************************/
        // /* STRYVE APP EXCEPTIONS */
        // /*************************/
        // if ($e instanceof InvalidSubdomainException) 
        //     return Larapi::respondBadRequest($e->getMessage(), $e->getCode());

        // if ($e instanceof InvalidSubdomainException) 
        //     return Larapi::respondBadRequest($e->getMessage(), $e->getCode());

        // if ($e instanceof AccountAlreadyExistsException) 
        //     return Larapi::respondBadRequest($e->getMessage(), $e->getCode());

        return parent::render($request, $e);
    }
}
