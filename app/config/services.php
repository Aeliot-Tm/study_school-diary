<?php

return [
    \Controller\DefaultController::class => [\Template\Menu::class],
    \Controller\EnrollmentController::class => [
        \Model\EnrollmentModel::class,
        \Model\UserModel::class,
        \Model\SubjectModel::class,
        \Template\Renderer::class,
    ],
    \Controller\SecurityController::class => [
        \Service\SecurityService::class,
        \Template\Menu::class,
        \Template\Renderer::class,
    ],
    \Controller\SubjectController::class => [\Model\SubjectModel::class, \Template\Renderer::class],
    \Controller\UserController::class => [\Model\UserModel::class, \Template\Renderer::class],
    \Core\DB\Connection::class => ['%database%'],
    \Core\Security\Guardian::class => [\Middleware\GuestMiddleware::class, \Middleware\RoleMiddleware::class],
    \Middleware\GuestMiddleware::class => [\Service\SecurityService::class],
    \Middleware\RoleMiddleware::class => ['%route_security%', \Service\SecurityService::class],
    \Model\EnrollmentModel::class => [\Core\DB\Connection::class],
    \Model\SubjectModel::class => [\Core\DB\Connection::class],
    \Model\UserModel::class => [\Core\DB\Connection::class, \Core\Security\PasswordHelper::class],
    \Service\SecurityService::class => [
        \Core\HTTP\SessionProvider::class,
        \Core\Security\PasswordHelper::class,
        \Model\UserModel::class,
    ],
    \Template\Menu::class => [\Template\MenuBuilder::class, \Template\MenuStorage::class],
    \Template\MenuBuilder::class => ['%menu%', '%route_security%', \Service\SecurityService::class],
    \Template\MenuStorage::class => [\Core\HTTP\SessionProvider::class],
    \Template\Renderer::class => ['%views%', \Template\Menu::class],
];
