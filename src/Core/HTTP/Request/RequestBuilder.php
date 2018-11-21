<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 21:24
 */

namespace Core\HTTP\Request;

use Core\State;
use Core\HTTP\Session;

class RequestBuilder
{
    /**
     * @return Request
     */
    public static function getInstance(): Request
    {
        $request = new Request(self::getPath(), self::getMethod());
        $request->request = self::getRequest();
        $request->headers = self::getHeaders();
        $request->session = self::getSession();

        return $request;
    }

    /**
     * @return State
     */
    private static function getHeaders(): State
    {
        return new State(apache_request_headers());
    }

    /**
     * @return string
     */
    private static function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @return State
     */
    private static function getRequest(): State
    {
        return new State($_REQUEST);
    }

    /**
     * @return Session
     */
    private static function getSession(): Session
    {
        return Session::getInstance();
    }

    /**
     * @return string
     */
    private static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}