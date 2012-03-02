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
        'ControllerBlogs' => 'blogs',
        'ControllerAdmin' => 'admin',
    ));

// Define routes

// Generate routes for each dynamic page
$pages = Database::$current
            ->Query('SELECT * FROM `cms_pages` WHERE `publisehd`=1')
            ->FetchArray();

if (count($pages) > 0)
{
    foreach ($pages as $page)
    {
        // Create a parameter named "slug" which will be how the controller
        // identifies what page to select from the database. This is a much
        // more readable than using just a plain page_id.
        Route::Set('page_' . $page['page_id'], // Unique rule name based on page_id
            '(?<slug>' . Slug($page['title']) . ')', 
            'ControllerMain', 'ActionPage'); // Our main controller will be responsible for displaying a page.
    }
}

Route::Set('blogs_entry', 'blogs/entry/(?<entry_id>[1-9]{1}[0-9]*)', 'ControllerBlogs', 'ActionEntry');
Route::Set('blogs_all', 'blogs/all', 'ControllerBlogs', 'ActionAll');
Route::Set('blogs', 'blogs', 'ControllerBlogs');

Route::Set('admin', 'admin', 'ControllerAdmin');

Route::Set('index', '', 'ControllerMain');

// Default "catch-all" route.
// Route::Set('index', '(?<ignore>.*)', 'ControllerMain');
?>
