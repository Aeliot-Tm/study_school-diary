<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 22:53
 */

namespace Core\HTTP\Response;

use Core\StreamInterface;

class Response
{
    const REDIRECT_FOUND = 302;
    const REDIRECT_SEE_OTHER = 303;
    const NOT_FOUND = 404;

    /**
     * @var string|resource
     */
    protected $stream = null;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $headers;

    /**
     * Response constructor.
     * @param StreamInterface $stream
     * @param int $code
     * @param array $headers
     * @param string|null $description
     */
    public function __construct(
        StreamInterface $stream,
        int $code = 200,
        array $headers = [],
        string $description = null
    ) {
        $this->stream = $stream;
        $this->code = $code;

        array_unshift($headers, sprintf("HTTP/1.0 %d %s", $code, $description ?: $this->getDescription($code)));
        $this->headers = $headers;
    }

    /**
     * @return void
     */
    public function send()
    {
        foreach ($this->prepareHeaders($this->headers) as $header) {
            header($header);
        }

        if ($this->stream) {
            echo (string)$this->stream->getContent();
        }
    }

    /**
     * @param int $code
     * @return string
     */
    protected function getDescription(int $code): string
    {
        $descriptions = [
            self::NOT_FOUND => 'Not Found',
            self::REDIRECT_FOUND => 'Found',
        ];

        return $descriptions[$code] ?? '';
    }

    /**
     * @param array $headers
     * @return array
     */
    private function prepareHeaders(array $headers): array
    {
        $prepared = [];
        foreach ($headers as $key => $value) {
            $prepared[] = is_numeric($key) ? $value : sprintf('%s: %s', $key, $value);
        }

        return $prepared;
    }
}
