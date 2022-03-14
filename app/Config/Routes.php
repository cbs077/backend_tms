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
  // Filter on route group
  // $routes->group("admin", ["filter" => "myauth"] , function($routes){

  //   $routes->post("sales", "AdminController::sales");
  //   $routes->put("transactions", "ApiController::transactions");
  // });

  //common
  $routes->group("/", function($routes){  // 개발용 authGuard
    $routes->post('signup', 'Home::signup');
    $routes->get('login/', 'Home::loginAuth');
    $routes->get('logout/', 'Home::logout');
    $routes->post('upload', 'Home::upload');
  });

  //$routes->group("/", function($routes){  // 개발용 authGuard
  $routes->group("/", ["filter" => "authGuard"] , function($routes){
    // user
    $routes->get('user/idcheck', 'User::getUserIdCheck');
    $routes->get('getUserMgList', 'User::getUserMgList');
    $routes->get('getUserInfo/(:any)', 'User::getUserInfo/$1');
    $routes->put('updateUserInfo', 'User::updateUserInfo');
    $routes->put('updatepwd/', 'User::updatePwd');
    $routes->post('user/', 'User::insertUserMg');

    // van
    $routes->get('van/list', 'Van::getVanMgList');
    $routes->get('van', 'Van::getVanMgInfo');
    $routes->get('van/(:num)', 'Van::getVanMg/$1');
    $routes->get('van/idcheck/(:num)', 'Van::getVanIdCheck/$1');
    $routes->post('van/', 'Van::insertVanMg');
    $routes->put('van/', 'Van::updateVanMg');

    // terminal
    $routes->get('terminal/list', 'Terminal::getTerminalList');
    $routes->get('terminal/(:num)/(:num)', 'Terminal::getTerminal/$1/$2');
    $routes->get('terminal/idcheck/(:any)/(:any)', 'Terminal::getCatIdCheck/$1/$2');
    $routes->post('terminal/', 'Terminal::insertTerminal');
    $routes->put('terminal/', 'Terminal::updateTerminal');
    $routes->delete('terminal/', 'Terminal::deleteTerminal');

    // terminal_stat  
    $routes->get('terminal/stat/list', 'TerminalStat::getTerminalUseInfoList');
    $routes->get('terminal/stat/van/list', 'TerminalStat::getTerminalVanInfoList');

    // terminal_reg_hist
    $routes->get('reghist/list', 'RegHist::getTerminalRegHist');
    $routes->get('reghist/(:num)/(:num)', 'RegHist::getTerminal/$1/$2');
    $routes->get('reghist/idcheck/(:num)/(:num)', 'RegHist::getCatIdCheck/$1/$2');
    $routes->post('reghist/', 'RegHist::insertRegHist');
    $routes->delete('reghist/', 'RegHist::deleteRegHist');

    // terminalmdl
    $routes->get('terminal_mdl/list', 'TerminalMdl::getTerminalMdlList');
  // $routes->get('terminal_mdl/info', 'TerminalMdl::getTerminalMdlInfo');
    $routes->get('terminal_mdl', 'TerminalMdl::getTerminalMdl');
    $routes->get('terminal_mdl/idcheck/(:any)/(:any)', 'TerminalMdl::getMdlIdCheck/$1/$2');
    $routes->post('terminal_mdl/', 'TerminalMdl::insertTerminalMdl');
    $routes->put('terminal_mdl/', 'TerminalMdl::updateTerminalMdl');

    //swgroup SwGroup contollrer 이름 관계있음.
    $routes->get('swgroup/list', 'SwGroup::getSwGroupMgList');
    $routes->get('swgroup', 'SwGroup::getSwGroupMg');
    $routes->get('swgroup/idcheck/(:any)/(:any)', 'SwGroup::getSwGroupIdCheck/$1/$2');
    $routes->post('swgroup/', 'SwGroup::insertSwGroupMg');
    $routes->put('swgroup/', 'SwGroup::updateSwGroupMg/');
    $routes->delete('swgroup/', 'SwGroup::deleteTerminal');

    //swoprmg 
    $routes->get('swoprmg/list', 'SwOprMg::getSwOprMgList');
    $routes->get('swoprmg/upgrade/list', 'SwOprMg::getSwUpgradeList');
    $routes->get('swoprmg/up/moniter', 'SwOprMg::getSwUpdateList');
    $routes->get('swoprmg/up/moniter/default', 'SwOprMg::getSwUpdateListA');
    //$routes->get('swoprmg/(:any)/(:num)/(:num)', 'SwOprMg::getSwOprMg/$1/$2/$3');
    $routes->delete('swoprmg/(:any)/(:num)/(:num)', 'SwOprMg::deleteSwOprMg/$1/$2/$3');
    $routes->get('swoprmg/idcheck/(:any)/(:any)/(:any)', 'SwOprMg::getSwIdCheck/$1/$2/$3');
    $routes->post('swoprmg/', 'SwOprMg::insertSwOprMg');

    //rccmd
    $routes->post('rccmd', 'RcCmd::insertRcCmd');


  });
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
