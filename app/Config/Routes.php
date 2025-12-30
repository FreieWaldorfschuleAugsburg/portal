<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IndexController::index', ['filter' => ['components']]);
$routes->get('/profile', 'ProfileController::index', ['filter' => ['login', 'components']]);

$routes->get('/student_reset', 'StudentResetController::index', ['filter' => ['login', 'components']]);

$routes->get('/change_password', 'PasswordController::changePassword', ['filter' => ['login', 'components']]);
$routes->post('/change_password', 'PasswordController::handleChangePassword', ['filter' => ['login', 'components']]);

$routes->get('/reset_password', 'PasswordController::resetPassword', ['filter' => ['components']]);
$routes->post('/reset_password', 'PasswordController::handleResetPassword', ['filter' => ['components']]);

$routes->get('/login', 'IndexController::index', ['filter' => ['login', 'components']]);
$routes->get('/logout', 'OAuthController::logout');
