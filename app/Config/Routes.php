<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IndexController::index', ['filter' => ['login', 'components']]);
$routes->get('/profile', 'ProfileController::index', ['filter' => ['login', 'components']]);

$routes->get('/student_reset', 'StudentResetController::index', ['filter' => ['login', 'components']]);

$routes->get('/change_password', 'PasswordController::changePassword', ['filter' => ['login', 'components']]);
$routes->get('/reset_password', 'PasswordController::resetPassword', ['filter' => ['components:noNavbar']]);

$routes->get('/logout', 'OAuthController::logout');
