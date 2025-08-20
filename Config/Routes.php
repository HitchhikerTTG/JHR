<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('OknoJohari');
$routes->setDefaultMethod('stworzOkno');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['GET', 'POST'], 'form/create', 'Form::create');
$routes->match(['GET', 'POST'], 'form/index', 'Form::index');
$routes->match(['GET','POST'], 'stworzOkno','OknoJohari::stworzOkno');
$routes->match(['GET','POST'], 'okno/(:segment)','OknoJohari::dodajDoOkna/$1');
// $routes->get('/', 'Home::index');
$routes->post('stworzOkno', 'OknoJohari::stworzOkno');
$routes->get('okno','OknoJohari::stworzOkno');
$routes->get('polityka','OknoJohari::polityka');
$routes->get('beta', 'OknoJohari::beta');
$routes->get('listaOkien/(:segment)','OknoJohari::wszystkieOkna/$1');
$routes->get('listaOkien', 'OknoJohari::wszystkieOkna');
$routes->get('wyswietlOkno/(:segment)/(:segment)','OknoJohari::wyswietlOkno/$1/$2');
$routes->get('wyswietlOkno/(:segment)/(:segment)/(:num)', 'OknoJohari::wyswietlOkno/$1/$2/$3');
$routes->get('testuje', 'Form::index');
$routes->post('testuje', 'Form::index');
$routes->match(['GET', 'POST'], '/tlumaczOkno/(:segment)/(:segment)', 'OknoJohari::tlumaczOkno/$1/$2');
$routes->post('log-js', 'JSLogger::logMessage');
$routes->get('migrate', 'Migrate::index');
$routes->get('migrate/reset', 'Migrate::reset');
$routes->get('debug/email-env', 'EmailEnvDebug::show');

// Debug emaili
$routes->get('emailDebug/debugEmail/(:any)/(:any)', 'EmailDebugController::debugEmail/$1/$2');
$routes->get('emailDebug/debugEmail/(:any)', 'EmailDebugController::debugEmail/$1');
$routes->get('emailDebug/debugEmail', 'EmailDebugController::debugEmail');
$routes->get('emailDebug/quickTest/(:any)', 'EmailDebugController::quickTest/$1');
$routes->get('emailDebug/quickTest', 'EmailDebugController::quickTest');

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