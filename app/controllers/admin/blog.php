<?php if (!defined('INDIRECT')) die();

ControllerTemplate::Load('admin/admin');

class ControllerAdminBlog extends ControllerAdmin
{
    public function ActionIndex()
    {
        $this->request->Redirect('admin/blog/list');
    }
    
    public function ActionList()
    {
        $this->template->Variables(array(
                'page_title' => 'Manage Blog',
                'content' => 'Blog list.',
                'user' => $this->user,
            ));
    }
}
?>
