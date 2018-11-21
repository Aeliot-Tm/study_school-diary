<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 17.11.2018
 * Time: 13:24
 */

namespace Enum;


final class Role
{
    const ADMIN = 'admin';
    const STUDENT = 'student';
    const TEACHER = 'teacher';

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::ADMIN,
            self::STUDENT,
            self::TEACHER,
        ];
    }

    /**
     * @return array
     */
    public static function getForEnrollment(): array
    {
        return [
            self::STUDENT,
            self::TEACHER,
        ];
    }
}