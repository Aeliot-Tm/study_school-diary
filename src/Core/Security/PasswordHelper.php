<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 0:11
 */

namespace Core\Security;


class PasswordHelper
{
    /**
     * @param string $plainPassword
     * @param string $salt
     * @return string
     */
    public function getHash(string $plainPassword, string $salt): string
    {
        return md5("$salt|$plainPassword");
    }

    /**
     * @param string $securityString
     * @return string
     */
    public function getPassword(string $securityString): string
    {
        $parts = explode(':', $securityString);

        return array_pop($parts);
    }

    /**
     * @param string $securityString
     * @return string
     */
    public function getSalt(string $securityString): string
    {
        $parts = explode(':', $securityString);

        return array_shift($parts);
    }

    /**
     * @param string $salt
     * @param string $hash
     * @return string
     */
    public function getSecurityString(string $salt, string $hash): string
    {
        return sprintf('%s:%s', $salt, $hash);
    }

    /**
     * @param string $securityString
     * @return bool
     */
    public function hasSalt(string $securityString): bool
    {
        return $securityString && strpos($securityString, ':');
    }
}
