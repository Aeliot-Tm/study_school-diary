<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 25.11.2018
 * Time: 11:11
 */

namespace Core\HTTP;


class SessionProvider
{
    /**
     * @return Session
     * @throws \Exception
     */
    public function __invoke()
    {
        return Session::getInstance();
    }
}
