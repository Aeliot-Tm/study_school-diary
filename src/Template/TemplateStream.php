<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 04.11.2018
 * Time: 0:20
 */

namespace Template;

use Core\StreamInterface;

/**
 * Class TemplateStream
 */
class TemplateStream implements StreamInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $path
     * @param array $parameters
     */
    public function __construct(string $path, array $parameters)
    {
        $this->path = $path;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getContent(): string
    {
        if (!$this->isParametersCanBeExtracted()) {
            throw new \Exception('Parameters cannot be extracted.');
        }
        ob_start();
        extract($this->parameters);
        require $this->path;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @return bool
     */
    private function isParametersCanBeExtracted(): bool
    {
        return count(array_intersect_key(get_defined_vars(), $this->parameters)) === 0;
    }
}
