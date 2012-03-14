<?php if (!defined('INDIRECT')) die();
class ControllerAdmin extends ControllerTemplate
{
    public $user = null;
    public $auth = null;
    public $template = 'admin/admin';
    
    public function Before()
    {
        parent::Before();
        
        // Get auth information
        $this->auth = Auth::Factory();
        $this->user = $this->auth->user();
        
        // If the user isn't authenticated, and the user isn't already
        // making some type of auth request, redirect to the auth page
        // notifying them that they must be authenticated.
        if (!$this->user && !preg_match(',^' . CMS::base_url()
            . 'admin/auth(/(.*))?$,', $this->request->uri()))
            $this->request->Redirect('admin/auth/status/access');
        
        // Users that are archived don't have access to the admin panel.
        if ($this->user['archived'])
            $this->request->Redirect('admin/auth/status/archived');
        
        $site_name = Database::current()
                         ->Query('SELECT `setting_value` FROM `cms_settings`'
                             . ' WHERE `setting_key`=\'site_name\' LIMIT 1')
                         ->Fetch();
        
        if ($site_name && isset($site_name['setting_value']))
            $site_name = $site_name['setting_value'];
        else
            $site_name = 'CMS';
        
        $this->template->Variables(array(
                'user'      => $this->user,
                'title'     => $site_name,
                'site_name' => $site_name,
            ));
    }
    
    public function ActionIndex()
    {
        $this->template->Variables(array(
                'page_title' => 'Admin',
                'content' => 'Welcome to the administration section.',
                'user' => $this->user,
            ));
        
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'access':
                $this->template->Variable('status_message',
                    'You do not have permission to access that feature.');
                break;
        }
    }
}
?>
