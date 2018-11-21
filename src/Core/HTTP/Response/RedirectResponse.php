<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 22:53
 */

namespace Core\HTTP\Response;

class RedirectResponse extends Response
{
    /**
     * Response constructor.
     * @param string $url
     * @param int $code
     * @param array $headers
     */
    public function __construct(
        string $url,
        int $code = 302,
        array $headers = []
    ) {
        $this->code = $code;

        array_unshift($headers, sprintf("Location: %s", $url));
        array_unshift($headers, sprintf("HTTP/1.0 %d %s", $code, $this->getDescription($code)));
        $this->headers = $headers;
    }
}
