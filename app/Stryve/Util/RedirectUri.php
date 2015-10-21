<?php

namespace Stryve\Util;

/**
 * RedirectUri class
 */
class RedirectUri
{
    /**
     * Generate a new redirect uri
     *
     * @param string $uri            The base URI
     * @param array  $params         The query string parameters
     * @param string $queryDelimeter The query string delimeter (default: "?")
     *
     * @return string The updated URI
     */
    public static function make($uri, $params = [], $queryDelimeter = '?')
    {
        $uri .= (strstr($uri, $queryDelimeter) === false) ? $queryDelimeter : '&';

        return $uri.http_build_query($params);
    }
}