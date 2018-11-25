<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 21:32
 */

namespace Core\HTTP;


class Session
{
    /**
     * @var self
     */
    private static $instance;

    /**
     *
     */
    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->start();
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return session_write_close();
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     * @throws \LogicException
     */
    public function get(string $name, $default = null)
    {
        if (!$this->hasStarted()) {
            throw new \LogicException('Session has not started yet');
        }

        return $_SESSION[$name] ?? $default;
    }

    /**
     * @return bool
     */
    public function hasStarted(): bool
    {
        return php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isset(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \LogicException
     */
    public function set(string $name, $value)
    {
        if (!$this->hasStarted()) {
            throw new \LogicException('Session has not started yet');
        }

        $_SESSION[$name] = $value;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function start(): bool
    {
        if (!$this->hasStarted()) {
            if (!session_start()) {
                throw new \Exception('Session cannot be started');
            }

            return true;
        }

        return false;
    }

    /**
     * @param string $name
     */
    public function unset(string $name)
    {
        unset($_SESSION[$name]);
    }
}
