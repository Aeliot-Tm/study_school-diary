<?php

return [
    \Controller\EnrollmentController::class => [
        \Model\EnrollmentModel::class,
        \Model\UserModel::class,
        \Model\SubjectModel::class,
        \Template\Renderer::class,
    ],
    \Controller\SecurityController::class => [\Service\SecurityService::class, \Template\Renderer::class],
    \Controller\SubjectController::class => [\Model\SubjectModel::class, \Template\Renderer::class],
    \Controller\UserController::class => [\Model\UserModel::class, \Template\Renderer::class],
    \Model\EnrollmentModel::class => [\Core\DB\Connection::class],
    \Model\SubjectModel::class => [\Core\DB\Connection::class],
    \Model\UserModel::class => [\Core\DB\Connection::class],
    \Service\SecurityService::class => [\Model\UserModel::class],
    \Template\MenuBuilder::class => ['%menu%', \Service\SecurityService::class],
    \Template\Renderer::class => ['%views%', \Template\MenuBuilder::class],
];
