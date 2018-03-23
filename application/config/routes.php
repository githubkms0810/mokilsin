<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main/base';

//admin login
$route['admin'] = 'user/base/login';

// $route['default_controller'] = 'test/base';
// $route['default_controller'] = 'content/base/list';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//test

$route['test/test1'] = 'test/base/test1';
$route['test/test2'] = 'test/base/test2';
$route['test/(:any)'] = 'test/base/$1';

// $route['sample'] = 'sample';
// $route['sample/(:any)'] = 'sample/$1';
// $route['sample/(:any)/(:any)'] = 'sample/$1/$2';
// $route['test/test2'] = 'test/base/test2';

//common
$route['upload'] = 'file/base/uploadFile';
$route['uploadImage'] = 'file/base/uploadImage';
$route['download/(:num)'] = 'file/base/downloadOnUser/$1';
$route['admin/list'] = 'common_admin/ajaxGetList';
$route['admin/list/(:num)'] = 'common_admin/ajaxGetList/$1';

// $route['([A-z]+)/([A-z]+)'] = '$1/$2';

//admin
$route['init'] = 'init';
$route['admin/([A-z]+)/(:num)'] = '$1/admin/get/$2';
$route['admin/(:any)/(:any)'] = '$1/admin/$2';
$route['admin/(:any)/(:any)/(:any)'] = '$1/admin/$2/$3';

//oauth
$route['oauth/(:any)/(:any)'] = 'oauth/$1/$2';

//내부 api
$route['api/user/login'] = 'user/api/login';

$route['api/([A-z]+)/list'] = '$1/api/list';
$route['api/([A-z]+)/([A-z]+)/(:any)'] = '$1/api/$2/$3';
$route['api/license/(:any)'] = 'license/api/get/$1';
$route['api/([A-z]+)/(:num)'] = '$1/api/get/$2';
$route['api/([A-z]+)/(:any)'] = '$1/api/$2';
//

//base
$route['([A-z]+)'] = '$1/base/index';
$route['([A-z]+)/(:num)'] = '$1/base/get/$2';
$route['([A-z]+)/([A-z]+)'] = '$1/base/$2';
$route['([A-z]+)/([A-z]+)/(:num)'] = '$1/base/$2/$3';
