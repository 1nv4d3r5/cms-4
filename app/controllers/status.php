<?php if (!defined('INDIRECT')) die();
class ControllerStatus extends Controller
{
    public function Action404()
    {
        $this->response->body(View::Factory('status/404'));
    }
}
?>
