<?php

use Enum\Role;

return [
    '^/users' => [Role::ADMIN],
    '^/subjects' => [Role::ADMIN, Role::STUDENT, Role::TEACHER],
    '^/enrollments' => [Role::ADMIN],
    '^/students' => [Role::TEACHER],
    '^/teachers' => [Role::STUDENT],
    '^/logout$' => [Role::ADMIN, Role::STUDENT, Role::TEACHER],
];
