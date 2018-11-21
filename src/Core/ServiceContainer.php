<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 22:16
 */

namespace Core;

final class ServiceContainer
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $services = [];

    /**
     * @param array $config
     */
    private function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param array|null $config
     * @return self
     */
    public static function getInstance(array $config = null): self
    {
        if ($config) {
            if (isset(self::$instance)) {
                throw new \LogicException('Service container has initiated already');
            }
            self::$instance = new self($config);
        } elseif (!isset(self::$instance)) {
            throw new \LogicException('Config is required for instantiation of service container');
        }

        return self::$instance;
    }

    /**
     * @param string $class
     * @return object
     */
    public function get(string $class)
    {
        if (!array_key_exists($class, $this->services)) {
            $this->services[$class] = $this->buildService($class);
        }

        return $this->services[$class];
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParameter(string $key, $default = null)
    {
        return $this->config['parameters'][$key] ?? $default;
    }

    /**
     * @param string $class
     * @param object $service
     * @return object
     */
    public function set(string $class, $service)
    {
        if (array_key_exists($class, $this->services)) {
            throw new \LogicException(sprintf('Service %s has configured', $class));
        }

        return $this->services[$class] = $service;
    }

    /**
     * @param string $class
     * @return object
     */
    private function buildService(string $class)
    {
        $config = $this->config['services'][$class] ?? [];
        foreach ($config as $index => $childKey) {
            if ($this->isParameter($childKey)) {
                $config[$index] = $this->getParameter(substr($childKey, 1, -1));
            } else {
                $config[$index] = $this->get($childKey);
            }
        }

        return new $class(...array_values($config));
    }

    /**
     * @param string $string
     * @return bool
     */
    private function isParameter(string $string): bool
    {
        return substr($string, 0, 1) == '%' && substr($string, -1) == "%";
    }
}