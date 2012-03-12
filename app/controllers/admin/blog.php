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
    
    public function ActionEdit()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        if (!$blog_entry_id)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        $edit_view = View::Factory('admin/blog/edit', array(
                'user'       => $this->user,
                'blog_entry' => Database::current()
                                    ->Query('SELECT * FROM `cms_blog_entries` WHERE '
                                        . '`blog_entry_id`=\''
                                        . Database::current()->Escape($blog_entry_id) . '\'')
                                    ->Fetch(),
            ));
        
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'title':
                $edit_view->Variable('status_message', 'Invalid title.');
                break;
            
            case 'saved':
                $edit_view->Variable('status_message', 'Changes has been successfully saved.');
                break;
            
            case 'exists':
                $edit_view->Variable('status_message', 'A blog entry already exists with specified title.');
                break;
        }
        
        
        
        $this->template->Variables(array(
                'head'       => View::Factory('admin/blog/head'),
                'page_title' => 'Manage Blog Entry',
                'content'    => $edit_view,
            ));
    }
}
?>
