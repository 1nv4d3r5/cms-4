<?php if (!defined('INDIRECT')) die();
class ControllerBlogs extends ControllerTemplate
{
    public $template = 'main';
    
    public function ActionEntry()
    {
        echo 'Blog entry #' . $this->request->parameter('entry_id');
    }
    
    public function ActionAll()
    {
        $entries = Database::$current
                        ->Query('SELECT * FROM `cms_blog_entries` ORDER BY `date_created` DESC')
                        ->FetchArray();
        
        $this->template->Variables(array(
            'page_title' => 'Blog Entries',
            'content' => View::Factory('blogs_all', array(
                'entries' => $entries,
                )),
            ));
    }
    
    public function ActionIndex()
    {
        Request::Initial()->Redirect('blogs/all');
    }
}
?>
