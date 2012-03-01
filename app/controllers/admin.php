<?php if (!defined('INDIRECT')) die();
class ControllerAdmin extends Controller
{
    public function ActionIndex()
    {
        $this->response->body(
                View::Factory('admin', array(
                    'admin' => 'This is the admin page!',
                    'test' => 'Some test data!!!',
                    )));
    }
}
?>
