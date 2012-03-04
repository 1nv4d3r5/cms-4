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
        
        $this->template->Variables(array(
                'page_title' => 'Manage Users',
                'content' => View::Factory('admin/user/list', array(
                        'users' => $users,
                    )),
            ));
    }
    
    public function ActionEdit()
    {
        $user_id = $this->request->parameter('user_id');
        
        $user = Database::current()
                     ->Query('SELECT * FROM `cms_users` WHERE `user_id`=\''
                         . Database::current()->Escape($user_id) . '\' LIMIT 1')
                     ->Fetch();
        
        if (!$user)
            $this->request->Redirect('admin/user');
        
        $this->template->Variables(array(
                'page_title' => 'Managing User ' . $user['username'],
                'content' => View::Factory('admin/user/edit', array(
                        'edit_user' => $user,
                    )),
            ));
    }
    
    public function ActionEditSave()
    {
        $user_id = $this->request->parameter('user_id');
        
        // Don't continue to save if the user didn't initiate submission of save
        // data for the specific user.
        if (!$this->request->post('save'))
            $this->request->Redirect('admin/user/edit/' . $user_id);
        
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $confirm_password = $this->request->post('confirm_password');
        $email = $this->request->post('email');
        $first_name = $this->request->post('first_name');
        $last_name = $this->request->post('last_name');
        $permission_manage_users = $this->request->post('permission_manage_users');
        $permission_pages_edit = $this->request->post('permission_pages_edit');
        $permission_pages_add = $this->request->post('permission_pages_add');
        $permission_blog_entry_edit = $this->request->post('permission_blog_entry_edit');
        $permission_blog_entry_add = $this->request->post('permission_blog_entry_add');
        $permission_blog_entry_credit_users = $this->request->post('permission_blog_entry_credit_users');
        
        $error = false;
        
        $update_password = false;
        
        if (strlen($username) <= 0)
            $error = true;
        
        if (strlen($password) > 0 && strlen($confirm_password) > 0)
            if ($password != $confirm_password)
                $error = true;
            else
                $update_password = true;
        
        if (!$error)
        {
            Database::current()
                ->Query('UPDATE `cms_users` SET '
                    . '`username`=\'' . Database::current()->Escape($username) . '\', '
                    . (($update_password) ? '`password`=\'' . sha1($password) . '\', ' : '')
                    . '`email`=\'' . Database::current()->Escape($email) . '\', '
                    . '`first_name`=\'' . Database::current()->Escape($first_name) . '\', '
                    . '`last_name`=\'' . Database::current()->Escape($last_name) . '\', '
                    . '`permission_manage_users`=' . (($permission_manage_users == 'true') ? 1 : 0) . ', '
                    . '`permission_pages_edit`=' . (($permission_pages_edit == 'true') ? 1 : 0) . ', '
                    . '`permission_pages_add`=' . (($permission_pages_add == 'true') ? 1 : 0) . ', '
                    . '`permission_blog_entry_edit`=' . (($permission_blog_entry_edit == 'true') ? 1 : 0) . ', '
                    . '`permission_blog_entry_add`=' . (($permission_blog_entry_add == 'true') ? 1 : 0) . ', '
                    . '`permission_blog_entry_credit_users`=' . (($permission_blog_entry_credit_users == 'true') ? 1 : 0) . ' '
                    . 'WHERE `user_id`=\'' . Database::current()->Escape($user_id) . '\'')
                ->Execute();
        }
        
        $this->request->Redirect('admin/user/edit/' . $user_id);
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