<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['default_controller'] = "login";
$route['404_override'] = '';

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();
//$where['menu_parent'] = 0;
$where['menu_type'] = 'frontend';
$where['menu_ctgr'] = 'header';
//$where['menu_active'] = 'Y';
$query = $db->get_where( 's_menu',$where);
$result = $query->result();
foreach( $result as $row ){
    $menuName = str_replace(".html","",strtolower($row->menu_alias));
    $whereChild['menu_parent'] = $row->id;
    $queryChild = $db->get_where( 's_menu' ,$whereChild);
    $resultChild = $queryChild ->result();
    if (sizeof($resultChild) == 0) {
//  	$route[$menuName.'.html'] = 'frontend';
        
        if ($row->is_static == 'Y') {
//            $route[$menuName.'.html'] = 'frontend';
            if ($row->menu_web_link != '') {
                $route[$row->menu_web_link.'/(:any)'] = $row->menu_web_link;
                
            } else {
                $route[$menuName.'/(:any)'] = 'frontend';
            }
            
        } else{
            $route[$row->menu_alias] = 'frontend';
        }

    } else {
        
        if ($row->is_static == 'Y') {
            if ($row->menu_web_link != '') {
                $route[$row->menu_web_link.'/(:any)'] = $row->menu_web_link;
            } else {
                $route[$menuName.'/(:any)'] = $row->menu_web_link;
            }
            
        } else{
            $route[$menuName.'/(:any)'] = 'frontend';
        }
    }
}
$route['our_business/(:any)'] = 'our_business';
$route['search/(:any)'] = 'search';
/* End of file routes.php */
/* Location: ./application/config/routes.php */