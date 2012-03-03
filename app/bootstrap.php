<?php if (!defined('INDIRECT')) die();

// Set server time zone and locale
date_default_timezone_set('America/Chicago');

setlocale(LC_ALL, 'en_US.utf-8');

// Load CMS
require_once SYSPATH . 'cms' . EXT;

CMS::Init(array(
        'base_url' => '/cms'
    ));

Route::RegisterControllers(array(
        'ControllerMain'  => 'main',
        'ControllerBlog'  => 'blog',
        'ControllerAdmin' => 'admin',
    ));

// Define routes

// Remember to order routes based on importance first. Once a route has been
// matched, the route is considered finished. No other routes will be attempted.

// Define blog pages before dynamic page routes are generated. This prevents
// any page from overriding any default route.
Route::Set('blog_entry', 'blog/entry/(?<slug>[^/]+)', 'ControllerBlog', 'ActionEntry');
Route::Set('blog_entries', 'blog/entries', 'ControllerBlog', 'ActionEntries');
Route::Set('blog', 'blog', 'ControllerBlog');

Route::Set('admin', 'admin', 'ControllerAdmin');
Route::Set('admin_auth', 'admin/auth', 'ControllerAdmin', 'ActionAuth');

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
