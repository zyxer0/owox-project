<?php

namespace App\Http\Conventions;

interface Request
{

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request
     */
    public static function getInstance();

    /**
     * Returns the request body content.
     *
     * @return string The request body content or a resource to read the body stream
     *
     * @throws \Exception
     */
    public function getContent();

    /**
     * Returns the root URL from which this request is executed.
     *
     * The base URL never ends with a /.
     *
     * This is similar to getBasePath(), except that it also includes the
     * script filename (e.g. index.php) if one exists.
     *
     * @return string The raw URL (i.e. not urldecoded)
     */
    public function getBaseUrl();

    /**
     * Gets the request's scheme.
     *
     * @return string
     */
    public function getScheme();

    /**
     * Returns the user.
     *
     * @return string|null
     */
    public function getUser();

    /**
     * Returns the password.
     *
     * @return string|null
     */
    public function getPassword();

    /**
     * @return mixed|null|string|string[]
     */
    public function getHost();

    /**
     * Returns the requested URI (path and query string).
     *
     * @return string The raw URI (i.e. not URI decoded)
     */
    public function getRequestUri();

    /**
     * Gets the scheme and HTTP host.
     *
     * If the URL was called with basic authentication, the user
     * and the password are not added to the generated string.
     *
     * @return string The scheme and HTTP host
     */
    public function getSchemeAndHttpHost();

    /**
     * Generates a normalized URI (URL) for the Request.
     *
     * @return string A normalized URI (URL) for the Request
     *
     * @see getQueryString()
     */
    public function getUri();

    /**
     * Returns the path being requested relative to the executed script.
     *
     * The path info always starts with a /.
     *
     * Suppose this request is instantiated from /mysite on localhost:
     *
     *  * http://localhost/mysite              returns an empty string
     *  * http://localhost/mysite/about        returns '/about'
     *  * http://localhost/mysite/enco%20ded   returns '/enco%20ded'
     *  * http://localhost/mysite/about?var=1  returns '/about'
     *
     * @return string The raw path (i.e. not urldecoded)gbbbb
     */
    public function getPathInfo();

    /**
     * @return path array
     *  * http://localhost/mysite              returns an empty array
     *  * http://localhost/mysite/about/pate   returns ['about', 'page']
     */
    public function getPathArray();

    /**
     * Generates the normalized query string for the Request.
     *
     * It builds a normalized query string, where keys/value pairs are alphabetized
     * and have consistent escaping.
     *
     * @return string|null A normalized query string for the Request
     */
    public function getQueryString();

    /**
     * Gets the request format.
     *
     * Here is the process to determine the format:
     *
     *  * format defined by the user (with setRequestFormat())
     *  * _format request attribute
     *  * $default
     *
     * @param string|null $default The default format
     *
     * @return string The request format
     */
    public function getRequestFormat($default = 'html');

    /**
     * Sets the request format.
     *
     * @param string $format The request format
     */
    public function setRequestFormat($format);

    /**
     * @param string $qa Query params array
     *
     * @return string A normalized query string for the Request
     */
    public static function buildQueryString($qa);


}
