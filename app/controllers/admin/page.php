<?php if (!defined('INDIRECT')) die();

ControllerTemplate::Load('admin/admin');

class ControllerAdminPage extends ControllerAdmin
{
    public function Before()
    {
        parent::Before();
        
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
}
?>
