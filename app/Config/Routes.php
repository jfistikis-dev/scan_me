<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\InvoiceController;

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
//$routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');
$routes->get('/sales', 'SalesController::index');
$routes->post('/sales', 'SalesController::store');
$routes->post('/sales/ajax-sales-entry', 'SalesController::ajaxNewSalesEntry');


$routes->get('/supplies', 'SuppliesController::index');
$routes->post('/supplies', 'SuppliesController::store');
$routes->get('/supplies/ajaxSearchList/(:alpha)', 'SuppliesController::ajaxSearchList/$1');


// ---- suppliers ---
$routes->get('/suppliers', 'SupplierController::index');
$routes->post('/suppliers/create', 'SupplierController::create');
$routes->delete( '/suppliers/(:num)', 'SupplierController::destroy/$1');
$routes->post( '/suppliers/sort', 'SupplierController::sort');
$routes->get('/suppliers/search', 'SupplierController::search');



// ---- products ---
$routes->get( '/products', 'ProductController::ajaxBarcodeSearch'); 





// ---- brands ---
$routes->get( '/brands', 'BrandController::index');
$routes->post('/brands/create', 'BrandController::create');
$routes->delete( '/brands/(:num)', 'BrandController::destroy/$1');
$routes->post( '/brands/sort', 'BrandController::sort');
//$routes->get( '/brands/search/(:any)', 'BrandController::search/$1');

// ---- suppliers ---
$routes->get('/measuring_units', 'MeasuringUnitController::index');
$routes->post('/measuring_units/create', 'MeasuringUnitController::create');
$routes->delete( '/measuring_units/delete/(:num)', 'MeasuringUnitController::destroy/$1');
$routes->post( '/measuring_units/sort', 'MeasuringUnitController::sort');
$routes->get('/measuring_units/search', 'MeasuringUnitController::search');



/*
// ---- Categories ---
$routes->get(  '/categories', 'CategoryController::index');
$routes->get( '/categories/search', 'CategoryController::search');
$routes->post( '/categories', 'CategoryController::store');
$routes->post( '/categories/delete', 'CategoryController::destroy');
$routes->post( '/categories/sort', 'CategoryController::sort');

//
$routes->get('/invoices/search/(:num)', 'InvoiceController::search/$1');
$routes->get('/invoices/ajaxGetlastinvoices', 'InvoiceController::ajaxGetlastinvoices');
$routes->get('/invoices/ajaxGetInvoice/(:num)' ,  'InvoiceController::ajaxGetInvoice/$1');
$routes->get('/invoices/ajaxRemoveInvoiceProduct/(:num)', 'InvoiceController::ajaxRemoveInvoiceProduct/$1');
$routes->post('/invoices/ajaxUpdateInvoiceDiscount/(:num)', 'InvoiceController::ajaxUpdateInvoiceDiscount/$1');
$routes->get('/invoices/calculate/(:num)', 'InvoiceController::calculateInvoiceSum/$1');

*/

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
