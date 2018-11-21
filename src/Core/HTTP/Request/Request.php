<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 21:20
 */

namespace Core\HTTP\Request;

use Core\State;
use Core\HTTP\Session;

/**
 * Class Request
 */
class Request
{
    const METHOD_DELETE = 'DELETE';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';

    /**
     * @var State|null
     */
    public $headers = null;

    /**
     * @var State|null
     */
    public $request = null;

    /**
     * @var Session|null
     */
    public $session = null;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * Request constructor.
     * @param string $path
     * @param string $method
     */
    public function __construct(string $path, string $method)
    {
        $this->path = $path;
        $this->method = $method;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->request ? $this->request->get($key, $default) : $default;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}