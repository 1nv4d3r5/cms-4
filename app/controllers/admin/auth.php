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
        
        // Redirect to admin if the user is already authenticated,
        // not logging out, and not archived.
        if ($this->user
            && ($this->request->uri() != CMS::base_url() . 'admin/auth/logout')
            && (!$this->user['archived']))
            $this->request->Redirect('admin');
    }
    
    public function ActionIndex()
    {
        $auth_view = View::Factory('admin/auth', array(
                'page_title' => 'Authentication',
            ));
        
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'failed':
                $auth_view->Variable('auth_status', 'Username or password is '
                        . 'incorrect. Please try again.');
                break;
            
            case 'archived':
                $this->auth->Deauthenticate();
                $auth_view->Variable('auth_status', 'Archived accounts cannot '
                        . 'be used to authenticate.');
                break;
            
            case 'access':
                $auth_view->Variable('auth_status', 'You must be authenticated '
                        . 'to proceed.');
                break;
            
            case 'logged-out':
                $auth_view->Variable('auth_status', 'You have been successfully'
                        . 'logged out.');
                break;
        }
        
        $this->response->body($auth_view);
    }
    
    public function ActionAuthLogin()
    {
        $this->user = $this->auth->Authenticate(
                $this->request->post('username'),
                $this->request->post('password'));
        
        if (!$this->user)
            $this->request->Redirect('admin/auth/status/failed');
        
        if ($this->user['archived'])
            $this->request->Redirect('admin/auth/status/archived');
        
        $this->request->Redirect('admin');
    }
    
    public function ActionAuthLogout()
    {
        $this->auth->Deauthenticate();
        $this->request->Redirect('admin/auth/status/logged-out');
    }
}
?>
