<?php if (!defined('INDIRECT')) die();

// Set server time zone and locale
date_default_timezone_set('America/Chicago');

setlocale(LC_ALL, 'en_US.utf-8');

// Load CMS
require_once SYSPATH . 'cms' . EXT;

CMS::Init(array(
        'base_url' => '/'
    ));

// Initialize modules
// TODO: Make modules more dynamic by allowing the programmer to specify an
// TODO: Make modules database-driven. This will allow the user to activate/deactivate modules through an interface
// init file to load the module.
CMS::Modules(array(
        'blog' => MODPATH . 'blog',
    ));

CMS::Models(array(
        'user' => APPPATH . 'models/user',
    ));

// Initialize our blog module
Blog::Init();

Route::RegisterControllers(array(
        'ControllerMain'   => 'main',
        'ControllerStatus' => 'status',

        // Admin Controllers
        'ControllerAdmin'  => 'admin/admin',
        'ControllerAdminAuth' => 'admin/auth',
        'ControllerAdminUser' => 'admin/user',
        'ControllerAdminPage' => 'admin/page',
    ));

// Define routes

// Remember to order routes based on importance first. Once a route has been
// matched, the route is considered finished. No other routes will be attempted.

// admin/user routes
Route::Set('admin_user', 'admin/user', 'ControllerAdminUser');
Route::Set('admin_user_list', 'admin/user/list(/status/(?<status>[^/]+))?', 'ControllerAdminUser', 'ActionList');
Route::Set('admin_user_edit', 'admin/user/edit/(?<user_id>[1-9]{1}[0-9]*)(/status/(?<status>.+))?', 'ControllerAdminUser', 'ActionEdit');
Route::Set('admin_user_edit_save', 'admin/user/edit/(?<user_id>[1-9]{1}[0-9]*)/save', 'ControllerAdminUser', 'ActionEditSave');
Route::Set('admin_user_new', 'admin/user/new(/status/(?<status>[^/]+))?', 'ControllerAdminUser', 'ActionNew');
Route::Set('admin_user_new_save', 'admin/user/new/save', 'ControllerAdminUser', 'ActionNewSave');
Route::Set('admin_user_delete', 'admin/user/delete/(?<user_id>[1-9]{1}[0-9]*)', 'ControllerAdminUser', 'ActionDelete');
Route::Set('admin_user_delete_confirmed', 'admin/user/delete/(?<user_id>[1-9]{1}[0-9]*)/confirmed', 'ControllerAdminUser', 'ActionDeleteConfirmed');
Route::Set('admin_user_archive', 'admin/user/archive/(?<user_id>[1-9]{1}[0-9]*)', 'ControllerAdminUser', 'ActionArchive');
Route::Set('admin_user_unarchive', 'admin/user/unarchive/(?<user_id>[1-9]{1}[0-9]*)', 'ControllerAdminUser', 'ActionUnarchive');

// admin/page routes
Route::Set('admin_page', 'admin/page', 'ControllerAdminPage');
Route::Set('admin_page_list', 'admin/page/list(/status/(?<status>[^/]+))?', 'ControllerAdminPage', 'ActionList');
Route::Set('admin_page_new', 'admin/page/new(/status/(?<status>[^/]+))?', 'ControllerAdminPage', 'ActionNew');
Route::Set('admin_page_new_save', 'admin/page/new/save', 'ControllerAdminPage', 'ActionNewSave');
Route::Set('admin_page_edit', 'admin/page/edit/(?<page_id>[1-9]{1}[0-9]*)(/status/(?<status>.+))?', 'ControllerAdminPage', 'ActionEdit');
Route::Set('admin_page_edit_save', 'admin/page/edit/(?<page_id>[1-9]{1}[0-9]*)/save', 'ControllerAdminPage', 'ActionEditSave');
Route::Set('admin_page_publish', 'admin/page/publish/(?<page_id>[1-9]{1}[0-9]*)', 'ControllerAdminPage', 'ActionPublish');
Route::Set('admin_page_unpublish', 'admin/page/unpublish/(?<page_id>[1-9]{1}[0-9]*)', 'ControllerAdminPage', 'ActionUnpublish');
Route::Set('admin_page_delete', 'admin/page/delete/(?<page_id>[1-9]{1}[0-9]*)', 'ControllerAdminPage', 'ActionDelete');
Route::Set('admin_page_delete_confirmed', 'admin/page/delete/(?<page_id>[1-9]{1}[0-9]*)/confirmed', 'ControllerAdminPage', 'ActionDeleteConfirmed');

// admin/auth routes
Route::Set('admin_auth_logout', 'admin/auth/logout', 'ControllerAdminAuth', 'ActionAuthLogout');
Route::Set('admin_auth_login', 'admin/auth/login', 'ControllerAdminAuth', 'ActionAuthLogin');
Route::Set('admin_auth', 'admin/auth(/status/(?<status>[^/]+))?', 'ControllerAdminAuth');
Route::Set('admin', 'admin(/status/(?<status>[^/]+))?', 'ControllerAdmin');

//Route::Set('status_404', '404', 'ControllerStatus', 'Action404');

// Generate routes for each dynamic page. Because non-deletable pages have
// custom controllers (for example, blogs), their pages will NOT
// be included in the dynamic route generation.

$pages = Database::current()
            ->Query('SELECT * FROM `cms_pages` WHERE `published`=1 AND deletable=1')
            ->FetchArray();

if (count($pages) > 0)
{
    foreach ($pages as $page)
    {
        // Create a parameter named "slug" which will be how the controller
        // identifies what page to select from the database. This is a much
        // more readable than using just a plain page_id.
        Route::Set('page_' . $page['page_id'], // Unique rule name based on page_id
            '(?<slug>' . $page['slug'] . ')', 
            'ControllerMain', 'ActionPage'); // Our main controller will be responsible for displaying a page.
    }
}

Route::Set('index', '', 'ControllerMain');

// Default "catch-all" route.
// Route::Set('index', '(?<ignore>.*)', 'ControllerMain');
?>
