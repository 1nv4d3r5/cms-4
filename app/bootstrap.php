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
            ->Query("SELECT * FROM `cms_pages`")
            ->FetchArray();

foreach ($pages as $page)
{
    Route::Set('page_' . $page['page_id'],
            '(?<slug>' . Slug($page['title']) . ')', 
            'ControllerMain', 'ActionPage');
}

Route::Set('blogs_entry', 'blogs/entry/(?<entry_id>[1-9]{1}[0-9]*)', 'ControllerBlogs', 'ActionEntry');
Route::Set('blogs_all', 'blogs/all', 'ControllerBlogs', 'ActionAll');
Route::Set('blogs', 'blogs', 'ControllerBlogs');

Route::Set('admin', 'admin', 'ControllerAdmin');

Route::Set('index', '', 'ControllerMain');

// Default "catch-all" route.
// Route::Set('index', '(?<ignore>.*)', 'ControllerMain');
?>
