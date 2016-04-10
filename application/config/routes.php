<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "entry/home";

$route['404_override'] = '';

/*
 * Frontend routes
 */

/*
 * Get details about an ad
 */
$route['ad/(:any)/(:any)'] = 'entry/ad';

$route['dashboard/ad'] = 'entry/dashboard_ad';

$route['dashboard/ad_list/(:any)'] = 'entry/ad_list';

$route['dashboard/ad/(:any)/(:any)'] = 'entry/dashboard_ad';

$route['ad/favourite'] = 'entry/ad';

/*
 * Search Route
 */
$route['search'] = 'entry/search';

$route['search/(:any)'] = 'entry/search';

/*
 * Product Details Page
 */
$route[''] = 'entry/product';


/*
 * Registration route
 */
$route['register'] = 'entry/register';

/*
 * Login route
 */
$route['login'] = 'entry/login';

/*
 * Logout route
 */
$route['logout'] = 'entry/logout';

/*
 * Forgot Password route
 */
$route['forgot_password'] = 'entry/forgot_password';

$route['forgot_password/(:any)'] = 'entry/forgot_password';

/*
 * Reset form
 */
$route['reset'] = 'entry/reset';


/*
 * Account Activation route
 */
$route['account/activate'] = 'entry/activate';

/*
 * Payment Route
 */
$route['payment'] = 'entry/payment/paypal';

$route['payment/eft'] = 'entry/payment/eft';

$route['payment/eft_success'] = 'entry/payment/eft_success';

$route['payment/eft_cancel'] = 'entry/payment/eft_cancel';

$route['payment/notify'] = 'entry/notify';
/*
 * Route any of the payments to payment
 */
$route['payment/(:any)'] = 'entry/payment';

/*
 * All ads by a user
 */
$route['ads/(:any)'] = 'entry/userads';


/*
 * Admin side routes
 */

$route['admin'] = 'entry/admin/login';

$route['admin/control_payment'] = 'entry/admin/control_payment';

$route['admin/control_payment/(:any)'] = 'entry/admin/control_payment';

$route['admin/sfi_control'] = 'entry/admin/sfi_control';

$route['admin/sfi_control/(:any)'] = 'entry/admin/sfi_control';

$route['admin/control_business'] = 'entry/admin/control_business';

$route['admin/control_business/(:any)'] = 'entry/admin/control_business';

$route['admin/control_user'] = 'entry/admin/control_user';

$route['admin/control_user/(:any)'] = 'entry/admin/control_user';

$route['admin/logout'] = 'entry/admin/logout';

$route['admin/login'] = 'entry/admin/login';

$route['admin/dashboard'] = 'entry/admin/dashboard';

$route['admin/dashboard/(:any)'] = 'entry/admin/dashboard';

$route['admin/category'] = 'entry/admin/category';

$route['admin/admin_post'] = 'entry/admin/admin_post';

$route['admin/admin_blog'] = 'entry/admin/admin_blog';

$route['admin/admin_social_links'] = 'entry/admin/admin_social_links';

$route['admin/invitation_gateway_links'] = 'entry/admin/invitation_gateway_links';

$route['admin/admin_logos'] = 'entry/admin/admin_logos';

$route['admin/lists'] = 'entry/admin/lists';

$route['admin/admin_activities'] = 'entry/admin/admin_activities';

$route['admin/admins'] = 'entry/admin/admins';

$route['admin/admins/(:any)'] = 'entry/admin/admins';


/*
 * Business Routes
 */
$route['dashboard'] = 'entry/dashboard';

$route['dashboard/(:any)'] = 'entry/dashboard/';

$route['support/(:any)'] = 'entry/support';

$route['verify'] = 'entry/verify';

$route['blog'] = 'entry/blog';

$route['blog/(:any)'] = 'entry/blog';
