<?php if (!defined('INDIRECT')) die();
class View
{
    protected $file;
    protected $variables;
    
    public static function Factory($file, $variables = array())
    {
        return new View($file, $variables);
    }
    
    function __construct($file, $variables = array())
    {
        $this->file = $file;
        $this->variables = $variables;
    }
    
    function __toString()
    {
        /* If a View instance is cast to a string, we'll go ahead and render.
         * This allows a view factory to be used as a string. For example, the following
         * could happen while inside a controller:
         * $this->response->body(View::Factory('myview', array('var1' => 'Hello, world!')));
         */
        return $this->Render();
    }
    
    public function Render()
    {
        // Start render buffer. This preserves all data from the view file.
        ob_start();
        
        // Create variables that the current view will use.
        extract($this->variables, EXTR_SKIP);
        
        // TODO: Allow the user to specify where they want their views folder to be.
        include APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->file . EXT;
        
        // Get buffered data and destroy the output buffer
        return ob_get_clean();
    }
}
?>
