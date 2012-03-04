<?php if (!defined('INDIRECT')) die();
class ControllerAdminUser extends Controller
{
    public function ActionIndex()
    {
        $this->request->Redirect('admin/user/list');
    }
    
    public function ActionList()
    {
        $this->response->body('User list');
    }
}
?>