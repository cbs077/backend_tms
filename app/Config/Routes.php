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
//$routes->get('/', 'Home::index');
  //$routes->resource('employee');
  //$routes->resource('user');
  //common
  $routes->post('signup', 'Home::signup');
  $routes->get('login/', 'Home::loginAuth');
  $routes->post('upload', 'Home::upload');

  // user
  $routes->get('user/(:string)', 'User::getUserInfo/$1');
  $routes->post('user/', 'User::insertUserMg');

  // van
  $routes->get('van/list', 'Van::getVanMgList');
  $routes->get('van/(:num)', 'Van::getVanMg/$1');
  $routes->get('van/idcheck/(:num)', 'Van::getVanIdCheck/$1');
  $routes->post('van/', 'Van::insertVanMg');

  // terminal
  $routes->get('terminal/list', 'Terminal::getTerminalList');
  $routes->get('terminal/(:num)/(:num)', 'Terminal::getTerminal/$1/$2');
  $routes->get('terminal/idcheck/(:num)/(:num)', 'Terminal::getCatIdCheck/$1/$2');
  $routes->post('terminal/', 'Terminal::insertTerminal');

  // terminalmdl
  $routes->get('terminal_mdl/list', 'TerminalMdl::getTerminalMdlList');
  $routes->get('terminal_mdl/(:num)/(:num)', 'TerminalMdl::getTerminalMdl/$1/$2');
  $routes->get('terminal_mdl/idcheck/(:num)/(:num)', 'TerminalMdl::getMdlIdCheck/$1/$2');
  $routes->post('terminal_mdl/', 'TerminalMdl::insertTerminalMdl');

  //swgroup SwGroup contollrer 이름 관계있음.
  $routes->get('swgroup/list', 'SwGroup::getSwGroupMgList');
  $routes->get('swgroup/(:num)/(:num)', 'SwGroup::getSwGroupMg/$1/$2');
  $routes->get('swgroup/idcheck/(:num)/(:num)', 'SwGroup::getSwGroupIdCheck/$1/$2');
  $routes->post('swgroup/', 'SwGroup::insertSwGroupMg');

  //swoprmg 
  $routes->get('swoprmg/list', 'SwOprMg::getSwOprMgList');
  // $routes->get('swoprmg/(:num)/(:num)', 'SwOprMg::getSwGroupMg/$1/$2');
  // $routes->get('swoprmg/idcheck/(:num)/(:num)', 'SwOprMg::getSwGroupIdCheck/$1/$2');
  $routes->post('swoprmg/', 'SwOprMg::insertSwOprMg');
  //$routes->resource('swgroup');

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
