<?php if (!defined('INDIRECT')) die();
class ControllerAdmin extends Controller
{
    public $user = null;
    public $auth = null;
    
    public function Before()
    {
        parent::Before();
        
        $this->auth = Auth::Factory();
        $this->user = $this->auth->user();
    }
    
    public function ActionIndex()
    {
        if (!$this->user)
            $this->request->Redirect('admin/auth');
        
        $this->response->body(View::Factory('admin', array(
                'page_title' => 'Admin',
                'content' => 'Admin section',
            )));
    }
    
    public function ActionAuth()
    {
        $this->response->body(View::Factory('admin/auth', array(
                'page_title' => 'Authentication',
                'content' => 'You must authenticate before proceeding.',
            )));
    }
}
?>
