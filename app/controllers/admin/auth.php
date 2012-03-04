<?php if (!defined('INDIRECT')) die();
class ControllerAdminAuth extends Controller
{
    public $user = null;
    public $auth = null;
    
    public function Before()
    {
        parent::Before();
        
        // Get auth information
        $this->auth = Auth::Factory();
        $this->user = $this->auth->user();
        
        // Redirect to admin if the user is already authenticated and not logging out
        if ($this->user && $this->request->uri() != CMS::base_url() . 'admin/auth/logout')
            $this->request->Redirect('admin');
    }
    
    public function ActionIndex()
    {
        $this->response->body(View::Factory('admin/auth', array(
                'page_title' => 'Authentication',
            )));
    }
    
    public function ActionAuthLogin()
    {
        $this->user = $this->auth->Authenticate($this->request->post('username'), 
                          $this->request->post('password'));
        
        if (!$this->user)
            $this->request->Redirect('admin/auth/status/failed');
        else
            $this->request->Redirect('admin');
    }
    
    public function ActionAuthLogout()
    {
        $this->auth->Deauthenticate();
        $this->request->Redirect('admin/auth/status/logged-out');
    }
    
    public function ActionAuthStatus()
    {
        $auth_status = 'Unknown error. Please try again later.';
        switch ($this->request->parameter('auth_status'))
        {
            case 'failed':
                $auth_status = 'Username or password is incorrect. Please try again.';
                break;
            
            case 'access':
                $auth_status = 'You must be authenticated to proceed.';
                break;
            
            case 'logged-out':
                $auth_status = 'You have been successfully logged out.';
                break;
        }
        
        $this->response->body(View::Factory('admin/auth', array(
                'page_title' => 'Authentication',
                'auth_status' => $auth_status,
            )));
    }
}
?>
