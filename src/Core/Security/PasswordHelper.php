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
     * @param string $token
     * @return string
     */
    public function getHashPart(string $token): string
    {
        $parts = explode(':', $token);

        return array_pop($parts);
    }

    /**
     * @param string $token
     * @return string
     */
    public function getSaltPart(string $token): string
    {
        $parts = explode(':', $token);

        return array_shift($parts);
    }

    /**
     * @param string $salt
     * @param string $hash
     * @return string
     */
    public function createToken(string $salt, string $hash): string
    {
        return sprintf('%s:%s', $salt, $hash);
    }

    /**
     * @param string|null $token
     * @return bool
     */
    public function hasSalt($token): bool
    {
        return $token && strpos($token, ':');
    }
}
