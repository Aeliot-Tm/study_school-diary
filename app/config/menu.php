<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 18.11.2018
 * Time: 0:21
 */

use Enum\Role;

return [
    ['url' => '/users', 'title' => 'Users', 'roles' => [Role::ADMIN]],
    ['url' => '/subjects', 'title' => 'Subjects', 'roles' => [Role::ADMIN, Role::STUDENT, Role::TEACHER]],
    ['url' => '/enrollments', 'title' => 'Enrollments', 'roles' => [Role::ADMIN]],
    //['url' => '/students', 'title' => 'Students', 'roles' => [Role::TEACHER]],
    //['url' => '/teachers', 'title' => 'Teachers', 'roles' => [Role::STUDENT]],
    ['url' => '/login', 'title' => 'Login', 'roles' => []],
    ['url' => '/logout', 'title' => 'Logout', 'roles' => [Role::ADMIN, Role::STUDENT, Role::TEACHER]],
];