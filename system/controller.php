<?php if (!defined('INDIRECT')) die();
abstract class Controller
{
    public $request = null;
    public $response = null;
    
    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    public function Before()
    {
        
    }
    
    public function After()
    {
        
    }
}

abstract class ControllerTemplate extends Controller
{
    public $template;
    
    public static function Load($name)
    {
        require APPPATH . 'controllers' . DIRECTORY_SEPARATOR . $name . EXT;
    }
    
    public function Before()
    {
        $this->template = View::Factory($this->template);
    }
    
    public function After()
    {
        $this->response->body($this->template->Render());
    }
}
?>
