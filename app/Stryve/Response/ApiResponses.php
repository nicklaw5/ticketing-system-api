<?php

namespace Stryve\Response;

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

    const SUCCESS_TEXT = 'succes';
    const ERROR_TEXT = 'error';

    
    public function __construct()
    {}

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
     * @return string
     */
    public function setStatusMessage($msg)
    {	
    	if(null === $msg)
    		$this->statusMessage = $this->getStatusMessage();
    	else
    		$this->statusMessage = (string) trim($msg);
        
        return $this;
    }

    /**
     * Returns 200 OK Response
     * 
     * @param  array $data
     * @param  string $msg
     * @return Response
     */
    public function respondOk($data = [], $msg = self::SUCCESS_TEXT)
    {
        return $this->setStatusText(self::$statusTexts[self::HTTP_OK])
        			->setStatusCode(self::HTTP_OK)
        			->setStatusMessage($msg)
        			->respondWithSuccessMessage($data);
    }

    /**
     * Returns 201 Created Response
     * 
     * @param  array $data
     * @param  string $msg
     * @return Response
     */
    public function respondCreated($data = [], $msg = self::SUCCESS_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_CREATED])
        			->setStatusCode(self::HTTP_CREATED)
        			->setStatusMessage($msg)
                    ->respondWithSuccessMessage($data);
    }

    /**
     * Returns 202 Accepted Response
     * 
     * @param  array $data
     * @param  string $msg
     * @return Response
     */
    public function respondAccepted($data = [], $msg = self::SUCCESS_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_ACCEPTED])
        			->setStatusCode(self::HTTP_ACCEPTED)
        			->setStatusMessage($msg)
                    ->respondWithSuccessMessage($data);
    }

    /**
     * Returns 400 Bad Request Response
     * 
     * @param  string $msg
     * @return Response
     */
    public function respondBadRequest($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_BAD_REQUEST])
                    ->setStatusCode(self::HTTP_BAD_REQUEST)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 401 Unauthorized Response
     * 
     * @param  string $msg
     * @return Response
     */
    public function respondUnauthorized($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_UNAUTHORIZED])
                    ->setStatusCode(self::HTTP_UNAUTHORIZED)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 403 Forbidden Response
     * 
     * @param  string $msg
     * @return Response
     */
    public function respondForbidden($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_FORBIDDEN])
                    ->setStatusCode(self::HTTP_FORBIDDEN)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 404 Not Found HTTP Response
     *
     * @param  string $msg
     * @return Response
     */
    public function respondNotFound($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_NOT_FOUND])
                    ->setStatusCode(self::HTTP_NOT_FOUND)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 405 Method Not Allowed Response
     *
     * @param  string $msg
     * @return Response
     */
    public function respondMethodNotAllowed($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_METHOD_NOT_ALLOWED])
                    ->setStatusCode(self::HTTP_METHOD_NOT_ALLOWED)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 500 Internal Server HTTP Response
     *
     * @param  string $msg
     * @return Response
     */
    public function respondInternalError($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_INTERNAL_SERVER_ERROR])
                    ->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 501 Not Implemented HTTP Response
     *
     * @param  string $msg
     * @return Response
     */
    public function respondNotImplemented($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_NOT_IMPLEMENTED])
                    ->setStatusCode(self::HTTP_NOT_IMPLEMENTED)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 503 Rate Limit Exceeded HTTP Response
     *      
     * @param  string $msg
     * @return Response
     */
    public function respondRateLimitExceeded($msg = 'error - api limit exceeded')
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_SERVICE_UNAVAILABLE])
                    ->setStatusCode(self::HTTP_SERVICE_UNAVAILABLE)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns 503 Not Available HTTP Response
     *
     * @param  string $msg
     * @return Response
     */
    public function respondNotAvailable($msg = self::ERROR_TEXT)
    {
        return $this->setStatusText($this->statusTexts[self::HTTP_SERVICE_UNAVAILABLE])
                    ->setStatusCode(self::HTTP_SERVICE_UNAVAILABLE)
                    ->setStatusMessage($msg)
                    ->respondWithErrorMessage();
    }

    /**
     * Returns JSON Encoded Response based on the set HTTP Status Code
     * 
     * @param  string $msg
     * @param  array $data
     * @return Response
     */
    public function respondWithSuccessMessage($data)
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
     * @param  string $msg
     * @return Response
     */
    public function respondWithErrorMessage()
    {
        return $this->respond([
            'code'      => $this->getStatusCode(),
            'status'    => $this->getStatusText(),
            'message'   => $this->getStatusMessage()
        ]);
    }

    /**
     * Returns JSON Encoded HTTP Reponse
     * 
     * @param  array $data
     * @param  array $headers
     * @return JsonReponse
     */
    public function respond($body, $headers = [])
    {
        return response()->json($body, $this->getStatusCode(), $headers);
    }

}