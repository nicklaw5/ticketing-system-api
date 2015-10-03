<?php

namespace App\Http\Controllers;

use Config;

class ApiResponses {

    // HTTP Response Codes
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_RATE_LIMIT_EXCEEDED = 503;
    const HTTP_SERVICE_UNAVAILABLE = 503;

    // Application Response Messages (see /app/config/httpresponses.php for default message text)
    const RESP_NO_ERROR = 0;
    const RESP_RATE_LIMITED_EXCEEDED = 1;

    /**
     * @var string
     */
    protected $status = 'success';

    /**
     * @var int
     */
    protected $statusCode = self::HTTP_OK;

    /**
     * @var string
     */
    protected $errorCode = self::RESP_NO_ERROR;

    /**
     * @var string
     */
    protected $errorText = 'No Error';

    /**
     * Gets the HTTP Response Status.
     *
     * @return string
     */
    protected function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the HTTP Response Status.
     *
     * @param string $status
     *
     * @return self
     */
    protected function setStatus($status = 'error')
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets the HTTP Status Code
     *
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the HTTP Status Code
     *
     * @param int $statusCode
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP Error Code
     *
     * @return int
     */
    protected function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets the HTTP Error Code
     *
     * @param int $errorCode
     * @return self
     */
    protected function setErrorCode($errorCode)
    {
        $this->errorCode = (is_null($errorCode))? $this->errorCode : (int) $errorCode;

        return $this;
    }

    /**
     * Gets the HTTP Error Text
     *
     * @return int
     */
    protected function getErrorText()
    {
        return $this->errorText;
    }

    /**
     * Sets the HTTP Error Text
     *
     * @param int $errorText
     * @return self
     */
    protected function setErrorText()
    {
        $this->errorText = Config::get("httpresponses.".$this->getErrorCode(), $this->getErrorText());

        return $this;
    }

    /**
     * Returns 200 OK Response
     * 
     * @param  array $data (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondOk($data = [], $message = 'OK')
    {
        return $this->respondWithSuccessMessage($message, $data);
    }

    /**
     * Returns 201 Created Response
     * 
     * @param  array $data (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondCreated($data = [], $message = 'Created')
    {
        return $this->setStatusCode(self::HTTP_CREATED)
                    ->respondWithSuccessMessage($message, $data);
    }

    /**
     * Returns 202 Accepted Response
     * 
     * @param  array $data (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondAccepted($data = [], $message = 'Accepted')
    {
        return $this->setStatusCode(self::HTTP_ACCEPTED)
                    ->respondWithSuccessMessage($message, $data);
    }

    /**
     * Returns 400 Bad Request Response
     * 
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondBadRequest($errorCode = null, $message = 'Bad Request')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_BAD_REQUEST)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 401 Unauthorized Response
     * 
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondUnauthorized($errorCode = null, $message = 'Unauthorized')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_UNAUTHORIZED)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 403 Forbidden Response
     * 
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondForbidden($errorCode = null, $message = 'Forbidden')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_FORBIDDEN)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 404 Not Found HTTP Response
     *
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondNotFound($errorCode = null, $message = 'Not Found')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_NOT_FOUND)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 405 Method Not Allowed Response
     *
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondMethodNotAllowed($errorCode = null, $message = 'Method Not Allowed')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_METHOD_NOT_ALLOWED)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 500 Internal Server HTTP Response
     *
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondInternalError($errorCode = null, $message = 'Internal Error')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 501 Not Implemented HTTP Response
     *
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondNotImplemented($errorCode = null, $message = 'Not Implemented')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_NOT_IMPLEMENTED)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 503 Rate Limit Exceeded HTTP Response
     *      
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondRateLimitExceeded($errorCode = self::RESP_RATE_LIMITED_EXCEEDED, 
                                             $message = 'Rate Limit Exceeded')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_RATE_LIMIT_EXCEEDED)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns 503 Not Available HTTP Response
     *
     * @param  string $errorCode (optional)
     * @param  string $message (optional)
     * @return Response
     */
    protected function respondNotAvailable($errorCode = null, $message = 'Not Available')
    {
        return $this->setStatus()
                    ->setStatusCode(self::HTTP_SERVICE_UNAVAILABLE)
                    ->setErrorCode($errorCode)
                    ->setErrorText()
                    ->respondWithErrorMessage($message);
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $message
     * @param  array $data
     * @return Response
     */
    protected function respondWithSuccessMessage($message, $data)
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatus(),
            'message'   => $message,
            'response'  => $data
        ]);
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $message
     * @return Response
     */
    protected function respondWithErrorMessage($message)
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatus(),
            'message'   => $message,
            'response'  => [
                'error-code' => $this->getErrorCode(),
                'error-text' => $this->getErrorText()
            ]
        ]);
    }

    /**
     * Returns JSON Encoded HTTP Reponse
     * 
     * @param  array $data
     * @param  array $headers (optional)
     * @return JsonReponse
     */
    protected function respond($body, $headers = [])
    {
        return response()->json($body, $this->getStatusCode(), $headers);
    }

}