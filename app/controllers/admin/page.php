<?php if (!defined('INDIRECT')) die();

ControllerTemplate::Load('admin/admin');

class ControllerAdminPage extends ControllerAdmin
{
    public function Before()
    {
        parent::Before();
        
        // If a user can't edit pages, then they cannot even add/delete/publish/unpublish pages.
        if (!$this->user['permission_pages_edit'])
            $this->request->Redirect('admin/status/access');
    }
    
    public function ActionIndex()
    {
        $this->request->Redirect('admin/page/list');
    }
    
    public function ActionList()
    {
        $list_view = View::Factory('admin/page/list', array(
                'user'  => $this->user,
                'pages' => Database::current()
                               ->Query('SELECT * FROM `cms_pages`')
                               ->FetchArray(),
            ));
        
        // Get a possible status message
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'added':
                $list_view->Variable('status_message', 'Page has been successfully added.');
                break;
            
            case 'deleted':
                $list_view->Variable('status_message', 'Page has been successfully deleted.');
                break;
            
            case 'published':
                $list_view->Variable('status_message', 'Page has been successfully published.');
                break;
            
            case 'unpublished':
                $list_view->Variable('status_message', 'Page has been successfully unpublished.');
                break;
            
            case 'not-unpublishable':
                $list_view->Variable('status_message', 'Default pages cannot be unpublished.');
                break;
            
            case 'not-found':
                $list_view->Variable('status_message', 'Page cannot be found.');
                break;
            
            case 'not-editable':
                $list_view->Variable('status_message', 'Page cannot be edited.');
                break;
            
            default:
                if ($status !== null)
                    $list_view->Variable('status_message', 'Unknown status: ' . $status);
                break;
        }
        
        $this->template->Variables(array(
                'page_title' => 'Manage Pages',
                'content' => $list_view,
            ));
    }
    
    public function ActionNew()
    {
        $new_view = View::Factory('admin/page/new');
        
        $status = $this->request->parameter('status');
        
        switch ($status)
        {
            case 'title':
                $new_view->Variable('status_message', 'Invalid page title.');
                break;
            
            case 'exists':
                $new_view->Variable('status_message', 'A page already exists with specified title.');
                break;
            
            default:
                if ($status !== null)
                    $new_view->Variable('status_message', 'Unknown status: ' . status);
                break;
        }
        
        $this->template->Variables(array(
                'head' => View::Factory('admin/page/head'),
                'page_title' => 'New Page',
                'content' => $new_view,
            ));
    }
    
    public function ActionNewSave()
    {
        $page_id = $this->request->parameter('page_id');
        
        $title = $this->request->post('title');
        $content = $this->request->post('content');
        
        // Invalid page title
        if (strlen($title) <= 0)
            $this->request->Redirect('admin/page/new/status/title');
        
        $page = Database::current()
                    ->Query('SELECT `page_id` FROM `cms_pages` WHERE '
                        . '`slug`=\'' . Database::current()->Escape(Slug($title)) . '\'')
                    ->Fetch();
        
        // Page title already exists
        if ($page)
            $this->request->Redirect('admin/page/new/status/exists');
        
        // TODO: Check for database errors
        Database::current()
            ->Query('INSERT INTO `cms_pages`(`title`,`content`,`slug`,`date_created`)'
                . ' VALUES('
                . '\'' . Database::current()->Escape($title) . '\', '
                . '\'' . Database::current()->Escape($content) . '\', '
                . '\'' . Database::current()->Escape(Slug($title)) . '\', '
                . 'NOW())')
            ->Execute();
        
        // Insert into menu database
        Database::current()
            ->Query('INSERT INTO `cms_menu`(`page_id`,`position`)'
                . 'VALUES('
                . Database::current()->InsertID() . ', '
                . '(SELECT COUNT(`page_id`) FROM (SELECT `page_id` FROM `cms_menu`) AS menu) + 1)')
            ->Execute();
        
        $this->request->Redirect('admin/page/list/status/added');
    }
    
    public function ActionEdit()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT * FROM `cms_pages` WHERE '
                        . '`page_id`=\'' . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        // Page cannot be edited
        if (!$page['editable'])
            $this->request->Redirect('admin/page/list/status/not-editable');
        
        $head_view = View::Factory('admin/page/head');
        $edit_view = View::Factory('admin/page/edit', array(
                'page' => $page,
            ));
        
        // Handle possible status messages
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
                $edit_view->Variable('status_message', 'A page already exists with specified title.');
                break;
        }
        
        $this->template->Variables(array(
                'head' => $head_view,
                'page_title' => 'Editing Page',
                'content' => $edit_view,
            ));
    }
    
    public function ActionEditSave()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT `page_id`,`editable` FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        // Page is not editable
        if (!$page['editable'])
            $this->request->Redirect('admin/page/list/status/not-editable');
        
        $title = $this->request->post('title');
        $content = $this->request->post('content');
        
        // Our only limitation is that the title has a length > 0
        if (strlen($title) <= 0)
            $this->request->Redirect('admin/page/edit/'
                . $page_id . '/status/title');
        
        $old_page = Database::current()
                        ->Query('SELECT `page_id` FROM `cms_pages` WHERE '
                            . '`slug`=\'' . Database::current()->Escape(Slug($title)) . '\' '
                            . 'AND `page_id`!=\'' . Database::current()->Escape($page_id) . '\'')
                        ->Fetch();
        
        // Page title already exists
        if ($old_page)
            $this->request->Redirect('admin/page/edit/' . $page_id . '/status/exists');
        
        // TODO: Check for database errors
        Database::current()
            ->Query('UPDATE `cms_pages` SET '
                . '`title`=\'' . Database::current()->Escape($title) . '\', '
                . '`content`=\'' . Database::current()->Escape($content) . '\', '
                . '`slug`=\'' . Database::current()->Escape(Slug($title)) . '\' '
                . 'WHERE `page_id`=\'' . Database::current()->Escape($page_id) . '\'')
            ->Execute();
        
        $this->request->Redirect('admin/page/edit/' . $page_id . '/status/saved');
    }
    
    public function ActionPublish()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT `page_id` FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        Database::current()
            ->Query('UPDATE `cms_pages` SET `published`=1 WHERE `page_id`=\''
                . Database::current()->Escape($page_id) . '\'')
            ->Execute();
        
        $this->request->Redirect('admin/page/list/status/published');
    }
    
    public function ActionUnpublish()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT `page_id`, `default` FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        // Page is default
        if ($page['default'])
            $this->request->Redirect('admin/page/list/status/not-unpublishable');
        
        Database::current()
            ->Query('UPDATE `cms_pages` SET `published`=0 WHERE `page_id`=\''
                . Database::current()->Escape($page_id) . '\'')
            ->Execute();
        
        $this->request->Redirect('admin/page/list/status/unpublished');
    }
    
    public function ActionDelete()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT * FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        $this->template->Variables(array(
                'page_title' => 'Confirm Page Deletion',
                'content' => View::Factory('admin/page/delete', array(
                        'page' => $page,
                    )),
            ));
    }
    
    public function ActionDeleteConfirmed()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT * FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/list/status/not-found');
        
        // Delete from menu. WARNING: It is VERY important that this is done
        // in a transaction. If this is not done in a transaction, there
        // will be two pages stuck with the same menu ID if an error occurs.
        Database::current()
            ->Begin()
            ->Query("UPDATE `cms_menu` SET `position`=`position` - 1 WHERE `position` > "
                . "(SELECT `position` FROM (SELECT * FROM `cms_menu`) as tmp WHERE `page_id`='"
                . Database::current()->Escape($page_id) . "')")
            ->Execute()
            ->Query("DELETE FROM `cms_menu` WHERE `page_id`='"
                . Database::current()->Escape($page_id) . "')")
            ->Execute()
            ->Commit();
        
        // Delete from pages
        Database::current()
                ->Query('DELETE FROM `cms_pages` WHERE `page_id`=\''
                    . Database::current()->Escape($page_id) . '\'')
                ->Execute();
        
        $this->request->Redirect('admin/page/list/status/deleted');
    }
}
?>
