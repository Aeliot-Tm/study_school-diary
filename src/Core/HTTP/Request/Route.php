<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 14:10
 */

namespace Core\HTTP\Request;

/**
 * Class Route
 */
class Route
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string|null
     */
    private $pattern = null;

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param string $path
     * @param callable $callable
     * @param array $rules
     */
    public function __construct(string $path, callable $callable, array $rules = [])
    {
        $this->path = $path;
        $this->callable = $callable;
        $this->addRules($path, $rules);
        $this->buildPattern();
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return array
     */
    public function getPathValues(string $path): array
    {
        $values = [];
        if ($this->rules && preg_match_all($this->pattern, $path, $matches)) {
            //THINK is we really need in keys?
            $values = array_combine(array_keys($this->rules), $matches[1]);
        }

        return $values;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function match(string $path): bool
    {
        return preg_match($this->pattern, $path);
    }

    /**
     * @param string $pattern
     * @param array $rules
     */
    private function addRules(string $pattern, array $rules)
    {
        $detectedKeys = $this->findKeys($pattern);
        if (array_diff(array_keys($rules), $detectedKeys)) {
            throw new \LogicException('Passed more rules than have detected keys');
        }
        $omittedKey = array_diff($detectedKeys, array_keys($rules));
        $omittedRules = array_combine($omittedKey, array_fill(0, count($omittedKey), '\W+'));
        $rules = array_merge($omittedRules, $rules);
        foreach ($detectedKeys as $key) {
            /**
             * THINK is we really need in sorted list
             * @see Route::getPathValues()
             */
            $this->rules[$key] = $rules[$key];
        }
    }

    /**
     * @return void
     */
    private function buildPattern()
    {
        $search = array_map(
            function (string $key) {
                return sprintf('{%s}', $key);
            },
            array_keys($this->rules)
        );
        $replace = array_map(
            function (string $rule) {
                return sprintf('(%s)', $rule);
            },
            array_values($this->rules)
        );
        $this->pattern = sprintf('~^%s$~i', str_replace($search, $replace, $this->path));
    }

    /**
     * @param string $pattern
     * @return array
     */
    private function findKeys(string $pattern): array
    {
        if (preg_match_all('~(?:^|/){([a-z][a-z09_]*)}(?:/|$)~i', $pattern, $matches)) {
            return $matches[1];
        }

        return [];
    }
}