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
        $list_view = View::Factory('admin/page/list', array('user' => $this->user));
        
        $pages = Database::current()
                    ->Query('SELECT * FROM `cms_pages`')
                    ->FetchArray();
        
        $list_view->Variable('pages', $pages);
        
        $this->template->Variables(array(
                'page_title' => 'Manage Pages',
                'content' => $list_view,
            ));
    }
    
    public function ActionNew()
    {
        
    }
    
    public function ActionNewSave()
    {
        
    }
    
    public function ActionEdit()
    {
        $page_id = $this->request->parameter('page_id');
        
        $page = Database::current()
                    ->Query('SELECT * FROM `cms_pages` WHERE `page_id`=\''
                        . Database::current()->Escape($page_id) . '\'')
                    ->Fetch();
        
        // Page does not exist
        if (!$page)
            $this->request->Redirect('admin/page/status/not-found');
        
        $head_view = View::Factory('admin/page/head');
        $edit_view = View::Factory('admin/page/edit', array(
                'page' => $page,
            ));
        
        
        $this->template->Variables(array(
                'head' => $head_view,
                'page_title' => 'Editing Page',
                'content' => $edit_view,
            ));
    }
    
    public function ActionEditSave()
    {
        
    }
    
    public function ActionPublish()
    {
        
    }
    
    public function ActionUnpublish()
    {
        
    }
    
    public function ActionDelete()
    {
        
    }
    
    public function ActionDeleteConfirmed()
    {
        
    }
}
?>
