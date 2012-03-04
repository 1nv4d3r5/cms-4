<?php if (!defined('INDIRECT')) die();

ControllerTemplate::Load('admin/admin');

class ControllerAdminUser extends ControllerAdmin
{
    public function ActionIndex()
    {
        $this->request->Redirect('admin/user/list');
    }
    
    public function ActionList()
    {
        // $this->response->body('User list');
        $this->template->Variables(array(
                'page_title' => 'Manage Users',
                'content' => 'User list.',
                'user' => $this->user,
            ));
    }
}
?>