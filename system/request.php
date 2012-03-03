<?php if (!defined('INDIRECT')) die();
class Request
{
    protected static $initial = null;
    
    public static function Init($request = null)
    {
        if ($request === null)
        {
            $request = $_SERVER;
        }
        
        if (!Request::$initial)
        {
            $uri = null;
            if (isset($request['REQUEST_URI']))
            {
                $uri = $request['REQUEST_URI'];
            }
            
            Request::$initial = new Request($uri);
        }
        
        return Request::$initial;
    }
    
    public static function Initial()
    {
        return Request::$initial;
    }
    
    public static function Factory($uri = null)
    {
        if ($uri === null)
        {
            $uri = $_SERVER['REQUEST_URI'];
            if ('' == $uri)
                $uri = '/';
        }
        
        return new Request($uri);
    }
    
    protected $uri;
    protected $parameters = array();
    
    function __construct($uri)
    {
        $this->uri = $uri;
    }
    
    public function uri($uri = null)
    {
        if ($uri === null)
            return $this->uri;
        
        $this->uri = $uri;

        return $this;
    }
    
    public function parameter($key, $value = null)
    {
        if ($value === null)
        {
            if (key_exists($key, $this->parameters))
                return $this->parameters[$key];
            else
                return null;
        }

        $this->parameters[$key] = $value;
        
        return $this;
    }
    
    public function parameters($parameters = null, $merge = true)
    {
        if ($parameters === null)
            return $this->parameters;
        
        if ($merge)
            $this->parameters = array_merge($this->parameters, $parameters);
        else
            $this->parameters = $parameters;
        
        return $this;
    }
    
    public function Redirect($location, $protocol = 'http')
    {
        if (strpos($location, '://') !== false)
            header('Location: ' . $location);
        else
            header('Location: ' . URL::Absolute($location, $protocol));
        exit;
    }
}
?>