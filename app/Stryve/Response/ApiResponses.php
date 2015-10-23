<?php

namespace Stryve\Response;

use Config;

class ApiResponses {

    // HTTP Response Codes
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    // OTHER CONSTANTS
    const ERROR_TEXT = 'error';
    const SUCCESS_TEXT = 'succes';
    const UNKNOWN_ERROR = 'An unknown error occured';

    /**
     * Status codes translation table.
     *
     * @var array
     */
    protected $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    );

    /**
     * @var string
     */
    protected $statusText = 'OK';

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var string
     */
    protected $statusMessage = 'success';

    /**
     * @var int
     */
    protected $errorCode = 0;

    /**
     * Instantiate a new class instance
     * 
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Gets the HTTP response status text.
     *
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * Sets the HTTP response status text.
     *
     * @param string $statusCode
     *
     * @return self
     */
    public function setStatusText($statusCode)
    {
        $this->statusText = $statusCode;

        return $this;
    }

    /**
     * Gets the HTTP Status Code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the HTTP Status Code
     *
     * @param int $statusCode
     * @return self
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * Gets the HTTP response message
     *
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * Sets the HTTP response message
     *
     * @param string $msg
     * @return $this
     */
    public function setStatusMessage($msg)
    {	
        $msg = trim((string) $msg);

    	if($msg === '')
    		$this->statusMessage = $this->getStatusMessage();
    	else
    		$this->statusMessage = $msg;
        
        return $this;
    }

    /**
     * Gets the error code
     * 
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets error message
     * 
     * @param string $msg
     * @return $this
     */
    public function setErrorMessage($msg)
    {
        $msg = trim($msg);
        $this->errorMessage = ($msg === '')? self::UNKNOWN_ERROR: $msg;

        return $this;
    }

    /**
     * Gets the error message
     * 
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set application error code
     *
     * @param int $code
     * @return $this
     */
    public function setErrorCode($code)
    {
        $this->errorCode = $code;

        return $this;
    }

    /**
     * Returns 200 OK Response
     * 
     * @param  array $data
     * @return json
     */
    public function respondOk($data = [])
    {
        return $this->getSuccessResponse($data, self::HTTP_OK);
    }

    /**
     * Returns 201 Created Response
     * 
     * @param  array $data
     * @return json
     */
    public function respondCreated($data = [])
    {
        return $this->getSuccessResponse($data, self::HTTP_CREATED);
    }

    /**
     * Returns 202 Accepted Response
     * 
     * @param  array $data
     * @param  string $msg
     * @return Response
     */
    public function respondAccepted($data = [])
    {
        return $this->getSuccessResponse($data, self::HTTP_ACCEPTED);
    }

    /**
     * Returns 400 Bad Request Response
     * 
     * @param  string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondBadRequest($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_BAD_REQUEST);
    }

    /**
     * Returns 401 Unauthorized Response
     * 
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondUnauthorized($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns 403 Forbidden Response
     * 
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondForbidden($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_FORBIDDEN);
    }

    /**
     * Returns 404 Not Found HTTP Response
     *
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondNotFound($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_NOT_FOUND);
    }

    /**
     * Returns 405 Method Not Allowed Response
     *
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondMethodNotAllowed($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_METHOD_NOT_ALLOWED);        
    }

    /**
     * Returns 500 Internal Server HTTP Response
     *
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondInternalError($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Returns 501 Not Implemented HTTP Response
     *
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondNotImplemented($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Returns 503 Rate Limit Exceeded HTTP Response
     *      
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondRateLimitExceeded($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Returns 503 Not Available HTTP Response
     *
     * @param string $msg
     * @param int $errorCode
     * @return json
     */
    public function respondNotAvailable($msg = '', $errorCode = 0)
    {
        return $this->getErrorResponse($msg, $errorCode, self::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Sets the success response
     *
     * @return json 
     */
    protected function getSuccessResponse($data, $statusText)
    {
        return $this->setStatusText($this->statusTexts[$statusText])
                    ->setStatusCode($statusText)
                    ->setStatusMessage(self::SUCCESS_TEXT)
                    ->respondWithSuccessMessage($data);
    }

    /**
     * Sets the error response
     *
     * @return json 
     */
    protected function getErrorResponse($msg, $errorCode, $statusText)
    {
        return $this->setStatusText($this->statusTexts[$statusText])
                    ->setStatusCode($statusText)
                    ->setStatusMessage(self::ERROR_TEXT)
                    ->setErrorCode($errorCode)
                    ->setErrorMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $msg
     * @param  array $data
     * @return Response
     */
    protected function respondWithSuccessMessage($data)
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatusText(),
            'message'   => $this->getStatusMessage(),
            'response'  => $data
        ]);
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @return json
     */
    protected function respondWithErrorMessage()
    {
        if($this->getErrorCode() === 0)
        {
            return $this->respond([
                'code'      => $this->getStatusCode(),
                'status'    => $this->getStatusText(),
                'message'   => $this->getStatusMessage()
            ]);
        }
        else
        {
            return $this->respond([
                'code'      => $this->getStatusCode(),
                'status'    => $this->getStatusText(),
                'message'   => $this->getStatusMessage(),
                'response'  => [
                    'error-code'    => $this->getErrorCode(),
                    'error-message' => $this->getErrorMessage()
                ]
            ]);
        }
    }

    /**
     * Returns JSON Encoded HTTP Reponse
     * 
     * @param  array $body
     * @param  array $headers
     * @return json
     */
    protected function respond($body, $headers = [])
    {
        return response()->json($body, $this->getStatusCode(), $headers);
    }

}