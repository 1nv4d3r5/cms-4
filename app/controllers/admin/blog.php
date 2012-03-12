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
        $list_view = View::Factory('admin/blog/list', array(
                'user'         => $this->user,
                'blog_entries' => Database::current()
                                      ->Query('SELECT * FROM `cms_blog_entries`')
                                      ->FetchArray(),
            ));
        
        $this->template->Variables(array(
                'page_title' => 'Manage Blog Entries',
                'content' => $list_view,
                'user' => $this->user,
            ));
    }
}
?>
