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
        $blog_entries = Database::current()
                            ->Query('SELECT * FROM `cms_blog_entries`')
                            ->FetchArray();
        
        $list_view = View::Factory('admin/blog/list', array(
                'user'         => $this->user,
                'blog_entries' => $blog_entries,
            ));
        
        // Get a possible status message
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'added':
                $list_view->Variable('status_message',
                        'Blog entry has been successfully added.');
                break;
            
            case 'deleted':
                $list_view->Variable('status_message',
                        'Blog entry has been successfully deleted.');
                break;
            
            case 'published':
                $list_view->Variable('status_message',
                        'Blog entry has been successfully published.');
                break;
            
            case 'unpublished':
                $list_view->Variable('status_message',
                        'Blog entry has been successfully unpublished.');
                break;
            
            case 'not-found':
                $list_view->Variable('status_message',
                        'Blog entry cannot be found.');
                break;
            
            case 'not-editable':
                $list_view->Variable('status_message',
                        'Blog entry cannot be edited.');
                break;
            
            default:
                if ($status !== null)
                    $list_view->Variable('status_message',
                            'Unknown status: ' . $status);
                break;
        }
        
        $this->template->Variables(array(
                'page_title' => 'Manage Blog Entries',
                'content' => $list_view,
                'user' => $this->user,
            ));
    }
    
    public function ActionNew()
    {
        $new_view = View::Factory('admin/blog/new');
        
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'title':
                $new_view->Variable('status_message',
                        'Invalid blog entry title.');
                break;
            
            case 'exists':
                $new_view->Variable('status_message',
                        'A blog entry already exists with specified title.');
                break;
            
            default:
                if ($status !== null)
                    $new_view->Variable('status_message',
                            'Unknown status: ' . status);
                break;
        }
        
        $this->template->Variables(array(
                'head'       => View::Factory('admin/blog/head'),
                'page_title' => 'New Blog Entry',
                'content'    => $new_view,
            ));
    }
    
    public function ActionNewSave()
    {
        $title = $this->request->post('title');
        $content = $this->request->post('content');
        
        // Invalid blog entry title
        if (strlen($title) <= 0)
            $this->request->Redirect('admin/blog/new/status/title');
        
        $page = Database::current()
                    ->Query('SELECT `blog_entry_id` FROM `cms_blog_entries`'
                            . 'WHERE `slug`=\''
                            . Database::current()->Escape(Slug($title)) . '\'')
                    ->Fetch();
        
        // Blog entry title already exists
        if ($page)
            $this->request->Redirect('admin/blog/new/status/exists');
        
        // TODO: Check for database errors
        Database::current()
            ->Query('INSERT INTO `cms_blog_entries`(`user_id`,`title`,`content`'
                . ',`slug`,`date_created`)'
                . ' VALUES('
                . '\'' . Database::current()->Escape($this->user['user_id'])
                . '\', '
                . '\'' . Database::current()->Escape($title) . '\', '
                . '\'' . Database::current()->Escape($content) . '\', '
                . '\'' . Database::current()->Escape(Slug($title)) . '\', '
                . 'NOW())')
            ->Execute();
        
        $blog_entry_id = Database::current()->InsertID();
        
        // Insert into history
        Database::current()
                ->Query('INSERT INTO `cms_blog_entry_history`(`blog_entry_id`,'
                    . '`user_id`,`date`,`action`) VALUES(\''
                    . Database::current()->Escape($blog_entry_id) . '\',\''
                    . Database::current()->Escape($this->user['user_id'])
                    . '\', NOW(), \'new\')')
                ->Execute();
        
        $this->request->Redirect('admin/blog/list/status/added');
    }
    
    public function ActionEdit()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        $blog_entry = Database::current()
                          ->Query('SELECT * FROM `cms_blog_entries` WHERE '
                              . '`blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id)
                              . '\'')
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
                $edit_view->Variable('status_message',
                        'Changes has been successfully saved.');
                break;
            
            case 'exists':
                $edit_view->Variable('status_message',
                        'A blog entry already exists with specified title.');
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
                    ->Query('SELECT `blog_entry_id`,`editable` '
                        . 'FROM `cms_blog_entries` WHERE `blog_entry_id`=\''
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
                              ->Query('SELECT `blog_entry_id` '
                                  . 'FROM `cms_blog_entries` WHERE '
                                  . '`slug`=\''
                                  . Database::current()->Escape(Slug($title))
                                  . '\' AND `blog_entry_id`!=\''
                                  . Database::current()->Escape($blog_entry_id)
                                  . '\'')
                              ->Fetch();
        
        // Blog entry title already exists
        if ($old_blog_entry)
            $this->request->Redirect('admin/blog/edit/' . $blog_entry_id
                    . '/status/exists');
        
        // TODO: Check for database errors
        Database::current()
            ->Query('UPDATE `cms_blog_entries` SET '
                . '`title`=\'' . Database::current()->Escape($title) . '\', '
                . '`content`=\'' . Database::current()->Escape($content) . '\','
                . '`slug`=\'' . Database::current()->Escape(Slug($title))
                . '\' WHERE `blog_entry_id`=\''
                . Database::current()->Escape($blog_entry_id) . '\'')
            ->Execute();
        
        // Insert into history
        Database::current()
            ->Query('INSERT INTO `cms_blog_entry_history`(`blog_entry_id`,'
                . '`user_id`,`date`,`action`) VALUES(\''
                . Database::current()->Escape($blog_entry_id) . '\',\''
                . Database::current()->Escape($this->user['user_id'])
                . '\', NOW(), \'edit\')')
            ->Execute();
        
        $this->request->Redirect('admin/blog/edit/' . $blog_entry_id
                . '/status/saved');
    }
    
    public function ActionPublish()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        // Make sure blog entry exists
        $blog_entry = Database::current()
                          ->Query('SELECT `blog_entry_id` '
                              . 'FROM `cms_blog_entries` '
                              . 'WHERE `blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id)
                              . '\'')
                          ->Fetch();
        
        // blog entry does not exist
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        Database::current()
            ->Query('UPDATE `cms_blog_entries` SET `published`=1 '
                . 'WHERE `blog_entry_id`=\''
                . Database::current()->Escape($blog_entry_id) . '\'')
            ->Execute();
        
        // Insert into history
        Database::current()
            ->Query('INSERT INTO `cms_blog_entry_history`(`blog_entry_id`,'
                . '`user_id`,`date`,`action`) VALUES(\''
                . Database::current()->Escape($blog_entry_id) . '\',\''
                . Database::current()->Escape($this->user['user_id'])
                . '\', NOW(), \'publish\')')
            ->Execute();
        
        $this->request->Redirect('admin/blog/list/status/published');
    }
    
    public function ActionUnpublish()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        // Make sure blog entry exists
        $blog_entry = Database::current()
                          ->Query('SELECT `blog_entry_id`'
                              . ' FROM `cms_blog_entries`'
                              . ' WHERE `blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id)
                              . '\'')
                          ->Fetch();
        
        // blog entry does not exist
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        Database::current()
            ->Query('UPDATE `cms_blog_entries` SET `published`=0 WHERE '
                . '`blog_entry_id`=\''
                . Database::current()->Escape($blog_entry_id) . '\'')
            ->Execute();
        
        // Insert into history
        Database::current()
            ->Query('INSERT INTO `cms_blog_entry_history`(`blog_entry_id`,'
                . '`user_id`,`date`,`action`) VALUES(\''
                . Database::current()->Escape($blog_entry_id) . '\',\''
                . Database::current()->Escape($this->user['user_id'])
                . '\', NOW(), \'unpublish\')')
            ->Execute();
        
        $this->request->Redirect('admin/blog/list/status/unpublished');
    }
    
    public function ActionDelete()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        // Make sure blog entry exists
        $blog_entry = Database::current()
                          ->Query('SELECT * FROM `cms_blog_entries` '
                              . 'WHERE `blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id)
                              . '\'')
                          ->Fetch();
        
        // blog entry does not exist
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        $this->template->Variables(array(
                'page_title' => 'Confirm Blog Entry Deletion',
                'content' => View::Factory('admin/blog/delete', array(
                        'blog_entry' => $blog_entry,
                    )),
            ));
    }
    
    public function ActionDeleteConfirmed()
    {
        $blog_entry_id = $this->request->parameter('blog_entry_id');
        
        // Make sure blog entry exists
        $blog_entry = Database::current()
                          ->Query('SELECT `blog_entry_id` '
                              . 'FROM `cms_blog_entries` '
                              . 'WHERE `blog_entry_id`=\''
                              . Database::current()->Escape($blog_entry_id)
                              . '\'')
                          ->Fetch();
        
        // blog entry does not exist
        if (!$blog_entry)
            $this->request->Redirect('admin/blog/list/status/not-found');
        
        // Delete from blog_entries
        Database::current()
                ->Query('DELETE FROM `cms_blog_entries` '
                    . 'WHERE `blog_entry_id`=\''
                    . Database::current()->Escape($blog_entry_id) . '\'')
                ->Execute();
        
        $this->request->Redirect('admin/blog/list/status/deleted');
    }
}
?>
