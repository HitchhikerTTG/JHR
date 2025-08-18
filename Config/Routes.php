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