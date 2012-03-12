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
        
        $blog_entry = Database::current()
                          ->Query('SELECT * FROM `cms_blog_entries` WHERE '
                              . '`blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id) . '\'')
                          ->Fetch();
        
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        $edit_view = View::Factory('admin/blog/edit', array(
                'user'       => $this->user,
                'blog_entry' => $blog_entry,
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
    
    public function ActionEditSave()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        $blog_entry = Database::current()
                    ->Query('SELECT `blog_entry_id`,`editable` FROM `cms_blog_entries` WHERE `blog_entry_id`=\''
                        . Database::current()->Escape($blog_entry_id) . '\'')
                    ->Fetch();
        
        // Blog entry does not exist
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        // Blog entry is not editable
        if (!$blog_entry['editable'])
            $this->request->Redirect('admin/blog/list/status/not-editable');
        
        $title = $this->request->post('title');
        $content = $this->request->post('content');
        
        // Our only limitation is that the title has a length > 0
        if (strlen($title) <= 0)
            $this->request->Redirect('admin/blog/edit/'
                . $blog_entry_id . '/status/title');
        
        $old_blog_entry = Database::current()
                              ->Query('SELECT `blog_entry_id` FROM `cms_blog_entries` WHERE '
                                  . '`slug`=\''
                                  . Database::current()->Escape(Slug($title)) . '\' '
                                  . 'AND `blog_entry_id`!=\''
                                  . Database::current()->Escape($blog_entry_id) . '\'')
                              ->Fetch();
        
        // Blog entry title already exists
        if ($old_blog_entry)
            $this->request->Redirect('admin/blog/edit/' . $blog_entry_id . '/status/exists');
        
        // TODO: Check for database errors
        Database::current()
            ->Query('UPDATE `cms_blog_entries` SET '
                . '`title`=\'' . Database::current()->Escape($title) . '\', '
                . '`content`=\'' . Database::current()->Escape($content) . '\', '
                . '`slug`=\'' . Database::current()->Escape(Slug($title)) . '\' '
                . 'WHERE `blog_entry_id`=\'' . Database::current()->Escape($blog_entry_id) . '\'')
            ->Execute();
        
        $this->request->Redirect('admin/blog/edit/' . $blog_entry_id . '/status/saved');
    }
}
?>
