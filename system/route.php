<?php if (!defined('INDIRECT')) die();
class Route
{
    protected static $routes;
    protected static $default_action = 'ActionIndex';
    protected static $controllers = array();
    
    public $name = null;
    public $path = null;
    public $controller = null;
    public $action = null;
    public $parameters = array();
    
    public static function RegisterController($controller, $file)
    {
        Route::$controllers[$controller] = $file;
    }
    
    public static function RegisterControllers($controllers = array())
    {
        Route::$controllers = array_merge(Route::$controllers, $controllers);
    }
    
    public static function Set($name, $path, $controller, $action = null)
    {
        return Route::$routes[$name] = new Route($name, $path, $controller, $action);
    }
    
    public static function Get($name)
    {
        if (key_exists($name, Route::$routes))
            return Route::$routes[$name];
        return null;
    }
    
    public function Action()
    {
        if ($this->action !== null)
            return $this->action;
        return Route::$default_action;
    }
    
    public static function Find($uri)
    {
        $correct_route = null;
        
        // Find Route matching the provided URI.
        foreach (Route::$routes as $route)
        {
            if (preg_match('`^' . CMS::base_url() . $route->path . '$`', $uri, $matches))
            {
                // Filter out all numeric keys. This is done to reduce
                // redundant data. If the route has named matches, then
                // they will be preserved and stored as parameters.
                foreach ($matches as $key => $match)
                {
                    if (!is_int($key))
                        $route->parameters[$key] = $match;
                }
                
                // Load the correct controller.
                require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR 
                        . Route::$controllers[$route->controller] . EXT;
                
                // Preserve route
                $correct_route = $route;
                
                break;
            }
        }
        
        return $correct_route;
    }
    
    function __construct($name, $path, $controller, $action = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->controller = $controller;
        
        if ($action !== null)
            $this->action = $action;
    }
}
?>
