<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
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
$routes->get('/', 'Home::dashboard');
$routes->get('contact', 'ContactController::index');

$routes->add('dashboard/ajaxList', 'Home::ajaxList');
$routes->add('dashboard/get', 'Home::getKaryawan');

$routes->get('deputi', 'DeputiController::index');
$routes->get('dashboard', 'Home::dashboard');

$routes->add('deputi/get', 'DeputiController::getDeputi');
$routes->add('deputi/ajaxList', 'DeputiController::ajaxList');

$routes->get('unit', 'UnitController::index');
$routes->add('unit/get', 'UnitController::getUnit');
$routes->add('unit/getbydir', 'UnitController::getUnitByDirektorat');

$routes->get('extention', 'ExtentionController::index');
$routes->add('extention/ajaxList', 'ExtentionController::ajaxList');
$routes->add('extention/get', 'ExtentionController::get');

$routes->group('', ['filter' => 'login'], function($routes){

    // $routes->get('contact', 'ContactController::index');
    // $routes->add('contact', 'ContactController::create');
    // $routes->add('contact/edit/(:segment)', 'ContactController::edit/$1');
    // $routes->get('contact/delete/(:segment)', 'ContactController::delete/$1');

    $routes->add('dashboard/create', 'Home::create');
    $routes->add('dashboard/edit/(:segment)', 'Home::edit/$1');
    $routes->get('dashboard/delete/(:segment)', 'Home::delete/$1');

    $routes->add('deputi/create', 'DeputiController::create');
    $routes->add('deputi/edit/(:segment)', 'DeputiController::edit/$1');
    $routes->get('deputi/delete/(:segment)', 'DeputiController::delete/$1');

    $routes->add('unit/create', 'UnitController::create');
    $routes->add('unit/edit/(:segment)', 'UnitController::edit/$1');
    $routes->get('unit/delete/(:segment)', 'UnitController::delete/$1');

    $routes->add('extention/create', 'ExtentionController::create');
    $routes->add('extention/edit/(:segment)', 'ExtentionController::edit/$1');
    $routes->get('extention/delete/(:segment)', 'ExtentionController::delete/$1');
});
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
