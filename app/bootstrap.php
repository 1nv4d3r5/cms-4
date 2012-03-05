<?php if (!defined('INDIRECT')) die();

// Set server time zone and locale
date_default_timezone_set('America/Chicago');

setlocale(LC_ALL, 'en_US.utf-8');

// Load CMS
require_once SYSPATH . 'cms' . EXT;

CMS::Init(array(
        'base_url' => '/'
    ));

Route::RegisterControllers(array(
        'ControllerMain'   => 'main',
        'ControllerStatus' => 'status',
        'ControllerBlog'   => 'blog',
    
        // Admin Controllers
        'ControllerAdmin'  => 'admin/admin',
        'ControllerAdminAuth' => 'admin/auth',
        'ControllerAdminUser' => 'admin/user',
        'ControllerAdminPage' => 'admin/page',
        'ControllerAdminBlog' => 'admin/blog',
    ));

// Define routes

// Remember to order routes based on importance first. Once a route has been
// matched, the route is considered finished. No other routes will be attempted.

// Define blog pages before dynamic page routes are generated. This prevents
// any page from overriding any default route.
Route::Set('blog_entry', 'blog/entry/(?<slug>[^/]+)', 'ControllerBlog', 'ActionEntry');
Route::Set('blog_entries', 'blog/entries', 'ControllerBlog', 'ActionEntries');
Route::Set('blog', 'blog', 'ControllerBlog');

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
Route::Set('admin_user_archive', 'admin/user/unarchive/(?<user_id>[1-9]{1}[0-9]*)', 'ControllerAdminUser', 'ActionUnarchive');

// admin/page routes
Route::Set('admin_page', 'admin/page', 'ControllerAdminPage');
Route::Set('admin_page_list', 'admin/page/list', 'ControllerAdminPage', 'ActionList');

// admin/blog routes
Route::Set('admin_blog', 'admin/blog', 'ControllerAdminBlog');
Route::Set('admin_blog_list', 'admin/blog/list', 'ControllerAdminBlog', 'ActionList');

// admin/auth routes
Route::Set('admin_auth_status', 'admin/auth/status(/(?<auth_status>.+))?', 'ControllerAdminAuth', 'ActionAuthStatus');
Route::Set('admin_auth_logout', 'admin/auth/logout', 'ControllerAdminAuth', 'ActionAuthLogout');
Route::Set('admin_auth_login', 'admin/auth/login', 'ControllerAdminAuth', 'ActionAuthLogin');
Route::Set('admin_auth', 'admin/auth', 'ControllerAdminAuth', 'ActionAuth');
Route::Set('admin', 'admin', 'ControllerAdmin');

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
