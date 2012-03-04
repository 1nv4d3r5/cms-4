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
        $users = Database::current()
                     ->Query('SELECT * FROM `cms_users`')
                     ->FetchArray();
        
        $content = '<table>';
        foreach ($users as $user)
        {
            $content .=
                '<tr>'
                    . '<td>' . $user['user_id'] . '</td>'
                    . '<td><a href="' . URL::Absolute('admin/user/edit/' . $user['user_id']) . '">'
                        . $user['username'] . '</a></td>'
                    . '<td><a href="' . URL::Absolute('admin/user/delete/' . $user['user_id']) . '">Delete</a></td>'
                . '</tr>';
        }
        $content .= '</table>';
        
        $this->template->Variables(array(
                'page_title' => 'Manage Users',
                'content' => 'User list.<br/>' . $content,
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
        
        // Don't continue to save if the user didn't initiate submission of save
        // data for the specific user.
        if (!$this->request->post('edit_save'))
            $this->request->Redirect('admin/user/edit/' . $user_id);
        
        $this->template->Variables(array(
                'page_title' => 'Managing User ' . $user_id,
                'content' => 'Save User ' . $user_id,
            ));
    }
    
    public function ActionDelete()
    {
        $this->template->Variables(array(
                'page_title' => 'Deleting User ' . $user_id,
                'content' => 'Deleting User ' . $user_id,
            ));
    }
}
?>