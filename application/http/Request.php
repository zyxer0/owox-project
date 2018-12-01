<?php

namespace App\Http;

use App\Http\Conventions\Request as RequestConventions;

class Request implements RequestConventions
{

    /**
     * Custom parameters.
     *
     * @var \App\Http\ParameterBag
     */
    public $attributes;

    /**
     * Request body parameters ($_POST).
     *
     * @var \App\Http\ParameterBag
     */
    public $request;

    /**
     * Query string parameters ($_GET).
     *
     * @var \App\Http\ParameterBag
     */
    public $query;

    /**
     * Server and execution environment parameters ($_SERVER).
     *
     * @var \App\Http\ServerBag
     */
    public $server;

    /**
     * Uploaded files ($_FILES).
     *
     * @var \App\Http\FileBag
     */
    public $files;

    /**
     * Cookies ($_COOKIE).
     *
     * @var \App\Http\ParameterBag
     */
    public $cookies;

    /**
     * Headers (taken from the $_SERVER).
     *
     * @var \App\Http\HeaderBag
     */
    public $headers;

    /**
     * @var string|resource|false|null
     */
    protected $content;

    /**
     * @var string
     */
    protected $requestUri;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $pathInfo;

    /**
     * @var string
     */
    protected $pathArray;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var Request
     */
    protected static $instance;

    /**
     * @return Request
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            $request = new self($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
            if (0 === strpos($request->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded')
                && in_array(strtoupper($request->server->get('REQUEST_METHOD', 'GET')), array('PUT', 'DELETE', 'PATCH'))
            ) {
                parse_str($request->getContent(), $data);
                $request->request = new ParameterBag($data);
            }
            self::$instance = $request;
        }
        return self::$instance;
    }

    /**
     * @param array $query The GET parameters
     * @param array $request The POST parameters
     * @param array $cookies The COOKIE parameters
     * @param array $files The FILES parameters
     * @param array $server The SERVER parameters
     */
    private function __construct(array $query = array(), array $request = array(), array $cookies = array(), array $files = array(), array $server = array())
    {
        $this->initialize($query, $request, $cookies, $files, $server);
    }

    private function __clone() {}

    /**
     * Sets the parameters for this request.
     *
     * This method also re-initializes all properties.
     *
     * @param array $query The GET parameters
     * @param array $request The POST parameters
     * @param array $cookies The COOKIE parameters
     * @param array $files The FILES parameters
     * @param array $server The SERVER parameters
     */
    private function initialize(array $query = array(), array $request = array(), array $cookies = array(), array $files = array(), array $server = array())
    {
        $this->request  = new ParameterBag($request);
        $this->query    = new ParameterBag($query);
        $this->cookies  = new ParameterBag($cookies);
        $this->files    = new FileBag($files);
        $this->server   = new ServerBag($server);
        $this->headers  = new HeaderBag($this->server->getHeaders());

        $this->content      = null;
        $this->requestUri   = null;
        $this->baseUrl      = null;
        $this->basePath     = null;
        $this->method       = null;
        $this->format       = null;
        $this->pathInfo     = null;
        $this->pathArray    = null;
    }

    public function getContent()
    {
        if (null === $this->content || false === $this->content) {
            $this->content = file_get_contents('php://input');
        }

        return $this->content;
    }

    /**
     * Returns the root URL from which this request is executed.
     *
     * The base URL never ends with a /.
     *
     * @return string The raw URL (i.e. not urldecoded)
     */
    public function getBaseUrl()
    {
        if (null === $this->baseUrl) {
            $this->baseUrl = $this->prepareBaseUrl();
        }

        return $this->baseUrl;
    }

    /**
     * Gets the request's scheme.
     *
     * @return string
     */
    public function getScheme()
    {

        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'? 'https' : 'http';
        if($_SERVER["SERVER_PORT"] == 443) {
            $protocol = 'https';
        } elseif (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $protocol = 'https';
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            $protocol = 'https';
        }

        return $protocol;
    }

    /**
     * Returns the user.
     *
     * @return string|null
     */
    public function getUser()
    {
        // TODO: Implement getUser() method.
    }

    /**
     * Returns the password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getRequestUri()
    {
        if (null === $this->requestUri) {
            $this->requestUri = $this->prepareRequestUri();
        }

        return $this->requestUri;
    }

    /**
     * @return mixed|null|string|string[]
     */
    public function getHost()
    {
        if (!$host = $this->headers->get('HOST')) {
            if (!$host = $this->server->get('SERVER_NAME')) {
                $host = $this->server->get('SERVER_ADDR', '');
            }
        }
        return $host;
    }

    /**
     * Gets the scheme and HTTP host.
     *
     * If the URL was called with basic authentication, the user
     * and the password are not added to the generated string.
     *
     * @return string The scheme and HTTP host
     */
    public function getSchemeAndHttpHost()
    {
        return $this->getScheme().'://'.$this->getHost();
    }

    /**
     * Generates a normalized URI (URL) for the Request.
     *
     * @return string A normalized URI (URL) for the Request
     *
     * @see getQueryString()
     */
    public function getUri()
    {
        if (null !== $qs = $this->getQueryString()) {
            $qs = '?'.$qs;
        }

        return $this->getSchemeAndHttpHost().$this->getBaseUrl().$this->getPathInfo().$qs;
    }

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
     * @return string The raw path (i.e. not urldecoded)
     */
    public function getPathInfo()
    {
        if (null === $this->pathInfo) {
            $this->pathInfo = $this->preparePathInfo();
        }

        return $this->pathInfo;
    }

    public function getPathArray()
    {
        if (null === $this->pathArray) {
            $pathInfo = $this->getPathInfo();

            $this->pathArray = explode('/', $pathInfo);
            $this->pathArray = array_filter($this->pathArray, function($element) {
                return !empty($element);
            });
        }
        return $this->pathArray;
    }

    /**
     * Generates the normalized query string for the Request.
     *
     * It builds a normalized query string, where keys/value pairs are alphabetized
     * and have consistent escaping.
     *
     * @return string|null A normalized query string for the Request
     */
    public function getQueryString()
    {
        $qs = static::buildQueryString($this->query->all());
        return '' === $qs ? null : $qs;
    }

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
    public function getRequestFormat($default = 'html')
    {
        if (null === $this->format) {
            $this->format = $this->attributes->get('_format');
        }

        return null === $this->format ? $default : $this->format;
    }

    /**
     * Sets the request format.
     *
     * @param string $format The request format
     */
    public function setRequestFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param array $qa Query params array
     *
     * @return string A normalized query string for the Request
     */
    public static function buildQueryString($qa)
    {
        if ([] == $qa) {
            return '';
        }
        ksort($qa);

        return http_build_query($qa, '', '&', PHP_QUERY_RFC3986);
    }

    protected function prepareRequestUri()
    {
        $requestUri = '';

        if ($this->server->has('REQUEST_URI')) {
            $requestUri = $this->server->get('REQUEST_URI');
            $schemeAndHttpHost = $this->getSchemeAndHttpHost();
            if (0 === strpos($requestUri, $schemeAndHttpHost)) {
                $requestUri = substr($requestUri, strlen($schemeAndHttpHost));
            }
        }

        $this->server->set('REQUEST_URI', $requestUri);

        return $requestUri;
    }

    /**
     * Prepares the path info.
     *
     * @return string path info
     */
    protected function preparePathInfo()
    {
        if (null === ($requestUri = $this->getRequestUri())) {
            return '/';
        }

        // Remove the query string from REQUEST_URI
        if (false !== $pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        if ('' !== $requestUri && '/' !== $requestUri[0]) {
            $requestUri = '/'.$requestUri;
        }

        if (null === ($baseUrl = $this->getBaseUrl())) {
            return $requestUri;
        }

        $pathInfo = substr($requestUri, strlen($baseUrl));
        if (false === $pathInfo || '' === $pathInfo) {
            // If substr() returns false then PATH_INFO is set to an empty string
            return '/';
        }

        return (string) $pathInfo;
    }

    /**
     * Prepares the base URL.
     *
     * @return string
     */
    protected function prepareBaseUrl()
    {
        $filename = basename($this->server->get('SCRIPT_FILENAME'));

        if (basename($this->server->get('SCRIPT_NAME')) === $filename) {
            $baseUrl = $this->server->get('SCRIPT_NAME');
        } elseif (basename($this->server->get('PHP_SELF')) === $filename) {
            $baseUrl = $this->server->get('PHP_SELF');
        } elseif (basename($this->server->get('ORIG_SCRIPT_NAME')) === $filename) {
            $baseUrl = $this->server->get('ORIG_SCRIPT_NAME'); // 1and1 shared hosting compatibility
        } else {
            // Backtrack up the script_filename to find the portion matching
            // php_self
            $path = $this->server->get('PHP_SELF', '');
            $file = $this->server->get('SCRIPT_FILENAME', '');
            $segs = explode('/', trim($file, '/'));
            $segs = array_reverse($segs);
            $index = 0;
            $last = count($segs);
            $baseUrl = '';
            do {
                $seg = $segs[$index];
                $baseUrl = '/'.$seg.$baseUrl;
                ++$index;
            } while ($last > $index && (false !== $pos = strpos($path, $baseUrl)) && 0 != $pos);
        }

        // Does the baseUrl have anything in common with the request_uri?
        $requestUri = $this->getRequestUri();
        if ('' !== $requestUri && '/' !== $requestUri[0]) {
            $requestUri = '/'.$requestUri;
        }

        if ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, $baseUrl)) {
            // full $baseUrl matches
            return $prefix;
        }

        if ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, rtrim(dirname($baseUrl), '/'.\DIRECTORY_SEPARATOR).'/')) {
            // directory portion of $baseUrl matches
            return rtrim($prefix, '/'.\DIRECTORY_SEPARATOR);
        }

        $truncatedRequestUri = $requestUri;
        if (false !== $pos = strpos($requestUri, '?')) {
            $truncatedRequestUri = substr($requestUri, 0, $pos);
        }

        $basename = basename($baseUrl);
        if (empty($basename) || !strpos(rawurldecode($truncatedRequestUri), $basename)) {
            // no match whatsoever; set it blank
            return '';
        }

        // If using mod_rewrite or ISAPI_Rewrite strip the script filename
        // out of baseUrl. $pos !== 0 makes sure it is not matching a value
        // from PATH_INFO or QUERY_STRING
        if (\strlen($requestUri) >= \strlen($baseUrl) && (false !== $pos = strpos($requestUri, $baseUrl)) && 0 !== $pos) {
            $baseUrl = substr($requestUri, 0, $pos + \strlen($baseUrl));
        }

        return rtrim($baseUrl, '/'.\DIRECTORY_SEPARATOR);
    }

    /*
     * Returns the prefix as encoded in the string when the string starts with
     * the given prefix, false otherwise.
     *
     * @return string|false The prefix as it is encoded in $string, or false
     */
    private function getUrlencodedPrefix(string $string, string $prefix)
    {
        if (0 !== strpos(rawurldecode($string), $prefix)) {
            return false;
        }

        $len = strlen($prefix);

        if (preg_match(sprintf('#^(%%[[:xdigit:]]{2}|.){%d}#', $len), $string, $match)) {
            return $match[0];
        }

        return false;
    }
}