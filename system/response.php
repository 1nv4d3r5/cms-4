<?php if (!defined('INDIRECT')) die();
class Response
{
    protected static $initial = null;
    
    public static function Init()
    {
        if (!Response::$initial)
        {
            Response::$initial = Response::Factory();
        }
    }
    
    public static function Initial()
    {
        return Response::$initial;
    }
    
    public static function Factory()
    {
        return new Response();
    }
    
    protected $body = null;
    
    public function Render()
    {
        return $this->body;
    }
    
    public function body($text = null)
    {
        if (null === $text)
            return $this->body;
        
        $this->body = $text;
        
        return $this;
    }
    
    function __toString()
    {
        return $this->Render();
    }
    
    function __construct()
    {
    }
}
?>
