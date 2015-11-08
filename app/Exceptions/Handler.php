<?php

namespace App\Exceptions;

use Exception;

// STRYVE HTTP EXCEPTIONS
use Stryve\Exceptions\Http\HttpNotFoundException;

// STRYVE APP EXCEPTIONS
// use Stryve\Exceptions\InvalidSubdomainException;
// use Stryve\Exceptions\TenantAlreadyExistsException;
// use Stryve\Exceptions\FailedTenantMigrationException;
// use Stryve\Exceptions\NoDatabaseConnectionFoundExceptoion;


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
            return $this->api->respondNotFound($e->getMessage(), $e->getCode());

        if ($e instanceof MethodNotAllowedHttpException)
            return $this->api->respondMethodNotAllowed($e->getMessage(), $e->getCode());

        /**************************/
        /* STRYVE HTTP EXCEPTIONS */
        /**************************/
        // if ($e instanceof MethodNotAllowedHttpException)
                    

        /*************************/
        /* STRYVE APP EXCEPTIONS */
        /*************************/
        // if ($e instanceof InvalidSubdomainException) 
        //     return $this->api->respondBadRequest($e->getMessage(), $e->getCode());

        // if ($e instanceof TenantAlreadyExistsException) 
        //     return $this->api->respondBadRequest($e->getMessage(), $e->getCode());

        // if ($e instanceof NoDatabaseConnectionFoundExceptoion) 
        //     return $this->api->respondNotFound($e->getMessage(), $e->getCode());

        // if ($e instanceof FailedTenantMigrationException) 
        //     return $this->api->respondInternalError($e->getMessage(), $e->getCode());

        return parent::render($request, $e);
    }
}
