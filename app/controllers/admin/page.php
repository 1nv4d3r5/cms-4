<?php if (!defined('INDIRECT')) die();

ControllerTemplate::Load('admin/admin');

class ControllerAdminPage extends ControllerAdmin
{
    public function ActionIndex()
    {
        $this->request->Redirect('admin/page/list');
    }
    
    public function ActionList()
    {
        $this->template->Variables(array(
                'page_title' => 'Manage Pages',
                'content' => 'Page list.',
                'user' => $this->user,
            ));
    }
}
?>
