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
}
?>
