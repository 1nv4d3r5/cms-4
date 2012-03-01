<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

define('EXT', '.php');

$app_path = 'app'; // app folder location relative to the path of this script
$system_path = 'system'; // system folder location relative to this script

define('APPPATH', realpath($app_path) . DIRECTORY_SEPARATOR);
unset($app_path);

define('SYSPATH', realpath($system_path) . DIRECTORY_SEPARATOR);
unset($system_path);

// INIDIRECT tells all included files that they are not being accessed directly
define('INDIRECT', true);

require_once APPPATH . 'bootstrap' . EXT;

$route = Route::Find(Request::Initial()->uri());

if ($route)
{
    Request::Initial()->parameters($route->parameters);
    
    // If using NetBeans, it will say there's an error here, but it
    // doesn't realize that $route->controller could contain subclasses
    // that extend Controller.
    
    $controller = new $route->controller(Request::Initial(), Response::Initial());
    $controller->Before();
    $action = $route->Action();
    $controller->$action();
    $controller->After();
    echo Response::Initial()->Render();
}
else
{
    // Page not found
    echo 'No controller found. ' . Request::Initial()->uri();
}
?>
