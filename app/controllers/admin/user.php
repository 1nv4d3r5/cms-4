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
        $this->template->Variables(array(
                'page_title' => 'Manage Users',
                'content' => 'User list.',
            ));
    }
    
    public function ActionEdit()
    {
        $user_id = $this->request->parameter('user_id');
        
        $this->template->Variables(array(
                'page_title' => 'Managing User ' . $user_id,
                'content' => 'User ' . $user_id,
            ));
    }
    
    public function ActionEditSave()
    {
        $user_id = $this->request->parameter('user_id');
        if (!$this->request->post('edit_save'))
            $this->request->Redirect('admin/user/edit/' . $user_id);
        
        $this->template->Variables(array(
                'page_title' => 'Managing User ' . $user_id,
                'content' => 'Save User ' . $user_id,
            ));
    }
    
    public function ActionDelete()
    {
        
    }
}
?>