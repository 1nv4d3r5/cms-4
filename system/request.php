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
            if (array_key_exists('REQUEST_URI', $request))
            {
                $uri = $request['REQUEST_URI'];
            }
            
            Request::$initial = new Request($uri);
            
            // TODO: Clean super globals.
            Request::$initial->_post = $_POST;
            unset($_POST);
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
    
    protected $_uri;
    protected $_parameters = array();
    protected $_post = array();
    
    function __construct($uri)
    {
        $this->_uri = $uri;
    }
    
    public function uri($uri = null)
    {
        if ($uri === null)
            return $this->_uri;
        
        $this->_uri = $uri;

        return $this;
    }
    
    public function post($key)
    {
        if (array_key_exists($key, $this->_post))
            return $this->_post[$key];
        return null;
    }
    
    public function parameter($key, $value = null)
    {
        if ($value === null)
        {
            if (array_key_exists($key, $this->_parameters))
                return $this->_parameters[$key];
            else
                return null;
        }

        $this->_parameters[$key] = $value;
        
        return $this;
    }
    
    public function parameters($parameters = null, $merge = true)
    {
        if ($parameters === null)
            return $this->_parameters;
        
        if ($merge)
            $this->_parameters = array_merge($this->_parameters, $parameters);
        else
            $this->_parameters = $parameters;
        
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