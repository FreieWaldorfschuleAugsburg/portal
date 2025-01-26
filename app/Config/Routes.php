<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Filters\AbsencesAdminFilter;
use App\Filters\AbsencesFilter;
use App\Filters\AdminFilter;
use App\Filters\LoggedInFilter;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setAutoRoute(false);
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('IndexController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'IndexController::index');

// Authentication
$routes->get('/login', 'AuthenticationController::login');
$routes->post('/login', 'AuthenticationController::handleLogin');
$routes->get('/logout', 'AuthenticationController::logout');

// Entries
$routes->get('/entries', 'EntryController::index', ['filter' => AdminFilter::class]);
$routes->post('/entries', 'EntryController::store', ['filter' => AdminFilter::class]);
$routes->get('/entries/new', 'EntryController::create', ['filter' => AdminFilter::class]);
$routes->post('/entries/new', 'EntryController::store', ['filter' => AdminFilter::class]);
$routes->get('/entries/edit/(:any)', 'EntryController::edit/$1', ['filter' => AdminFilter::class]);
$routes->post('/entries/edit/(:any)', 'EntryController::update/$1', ['filter' => AdminFilter::class]);
$routes->get('/entries/delete/(:any)', 'EntryController::delete/$1', ['filter' => AdminFilter::class]);

// Categories
$routes->get('/categories', 'CategoryController::index', ['filter' => AdminFilter::class]);
$routes->post('/categories', 'CategoryController::update', ['filter' => AdminFilter::class]);

// Roles
$routes->get('/roles', 'RoleController::index', ['filter' => AdminFilter::class]);
$routes->get('/roles/edit/(:any)', 'RoleController::edit/$1', ['filter' => AdminFilter::class]);
$routes->post('/roles/edit/(:any)', 'RoleController::update/$1', ['filter' => AdminFilter::class]);
$routes->get('/roles/delete/(:any)', 'RoleController::delete/$1', ['filter' => AdminFilter::class]);
$routes->get('/roles/new', 'RoleController::create', ['filter' => AdminFilter::class]);
$routes->post('/roles/new', 'RoleController::store', ['filter' => AdminFilter::class]);

// Absences
$routes->get('/absences', 'AbsenceController::index', ['filter' => AbsencesFilter::class]);
$routes->get('/absences/view/(:any)', 'AbsenceController::view/$1', ['filter' => AbsencesFilter::class]);
$routes->post('/absences/absent', 'AbsenceController::absent');
$routes->get('/absences/table', 'AbsenceController::table', ['filter' => AbsencesFilter::class]);
$routes->get('/absences/print/absence/(:any)', 'AbsenceController::printAbsence/$1', ['filter' => AbsencesFilter::class]);
$routes->get('/absences/print/presence/(:any)', 'AbsenceController::printPresence/$1', ['filter' => AbsencesFilter::class]);

$routes->post('/absences/table/print_absence', 'AbsenceController::tablePrintAbsence', ['filter' => AbsencesFilter::class]);
$routes->post('/absences/table/print_presence', 'AbsenceController::tablePrintPresence', ['filter' => AbsencesFilter::class]);

$routes->cli('/emails', 'EmailController::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
