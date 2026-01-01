<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IndexController::index', ['filter' => ['components']]);
$routes->get('/profile', 'ProfileController::index', ['filter' => ['login', 'components']]);
$routes->get('/login', 'IndexController::index', ['filter' => ['login', 'components']]);
$routes->get('/logout', 'OAuthController::logout');

$routes->get('/students', 'StudentManagementController::index', ['filter' => ['studentManagement', 'components']]);
$routes->get('/students/(:any)/password_reset', 'StudentManagementController::resetPassword/$1', ['filter' => ['studentManagement', 'components']]);
$routes->post('/students/(:any)/password_reset', 'StudentManagementController::handleResetPassword/$1', ['filter' => ['studentManagement', 'components']]);

$routes->get('/change_password', 'PasswordController::changePassword', ['filter' => ['login', 'components']]);
$routes->post('/change_password', 'PasswordController::handleChangePassword', ['filter' => ['login', 'components']]);

$routes->get('/reset_password', 'PasswordController::resetPassword', ['filter' => ['components']]);
$routes->post('/reset_password', 'PasswordController::handleResetPassword', ['filter' => ['components']]);


