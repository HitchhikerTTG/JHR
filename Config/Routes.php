<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
 
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('OknoJohari');
$routes->setDefaultMethod('index');
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
$routes->match(['get', 'post'], 'form/create', 'Form::create');
$routes->match(['get', 'post'], 'form/index', 'Form::index');
$routes->match(['get','post'], 'stworzOkno','OknoJohari::stworzOkno');
$routes->match(['get','post'], 'okno/(:segment)','OknoJohari::dodajDoOkna/$1');
$routes->get('okno','OknoJohari::stworzOkno');
$routes->get('/','OknoJohari::stworzOkno');
$routes->get('polityka','OknoJohari::polityka');
$routes->get('beta', 'OknoJohari::beta');
$routes->get('listaOkien/(:segment)','OknoJohari::wszystkieOkna/$1');
$routes->get('listaOkien', 'OknoJohari::wszystkieOkna');
$routes->get('wyswietlOkno/(:segment)/(:segment)','OknoJohari::wyswietlOkno/$1/$2');
$routes->get('testuje', 'Form::index');
$routes->post('testuje', 'Form::index');