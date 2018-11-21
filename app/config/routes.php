<?php
/**
 * Created by PhpStorm.
 * User: Aeliot
 * Date: 03.11.2018
 * Time: 16:21
 */

use Controller\EnrollmentController;
use Controller\SubjectController;
use Controller\UserController;
use Core\HTTP\Request\Router;

Router::add('/', [\Controller\DefaultController::class, 'index'], []);
//user
Router::add('/users', [UserController::class, 'list'], []);
Router::add('/users/create', [UserController::class, 'create']);
Router::add('/users/{id}/delete', [UserController::class, 'delete'], ['id' => '\\d+']);
Router::add('/users/{id}/edit', [UserController::class, 'edit'], ['id' => '\\d+']);
Router::add('/users/{id}/view', [UserController::class, 'view'], ['id' => '\\d+']);
//subject
Router::add('/subjects', [SubjectController::class, 'list'], []);
Router::add('/subjects/create', [SubjectController::class, 'create']);
Router::add('/subjects/{id}/delete', [SubjectController::class, 'delete'], ['id' => '\\d+']);
Router::add('/subjects/{id}/edit', [SubjectController::class, 'edit'], ['id' => '\\d+']);
Router::add('/subjects/{id}/view', [SubjectController::class, 'view'], ['id' => '\\d+']);
//enrollment
Router::add('/enrollments', [EnrollmentController::class, 'list'], []);
Router::add('/enrollments/create', [EnrollmentController::class, 'create']);
Router::add('/enrollments/{id}/delete', [EnrollmentController::class, 'delete'], ['id' => '\\d+']);
Router::add('/enrollments/{id}/edit', [EnrollmentController::class, 'edit'], ['id' => '\\d+']);
Router::add('/enrollments/{id}/view', [EnrollmentController::class, 'view'], ['id' => '\\d+']);

Router::add('/login', [\Controller\SecurityController::class, 'login']);
