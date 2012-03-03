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
        
        if (!$this->user && !preg_match(',^' . CMS::base_url()
            . 'admin/auth(/(.*))?$,', $this->request->uri()))
            $this->request->Redirect('admin/auth');
            
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
    
    public function ActionAuthLogin()
    {
        $this->request->Redirect('admin/auth/error/failed');
    }
    
    public function ActionAuthError()
    {
        $page_status = 'Unknown error. Please try again later.';
        switch ($this->request->parameter('error_status'))
        {
            case 'failed':
                $page_status = 'Username or password is incorrect. Please try again.';
                break;
            
            case 'access':
                $page_status = 'You must be authenticated to proceed.';
                break;
        }
        
        $this->response->body(View::Factory('admin/auth', array(
                'page_title' => 'Authentication',
                'page_status' => $page_status,
            )));
    }
}
?>
