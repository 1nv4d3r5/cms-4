<?php if (!defined('INDIRECT')) die();
class ControllerBlogs extends Controller
{
    public function ActionEntry()
    {
        echo 'Blog entry #' . $this->request->parameter('entry_id');
    }
    
    public function ActionAll()
    {
        echo 'Here are all of the blog posts!';
        
        $entries = Database::$current
                        ->Query('SELECT * FROM `cms_blog_entries` ORDER BY `date_created` DESC')
                        ->FetchArray();
        
        foreach ($entries as $value)
        {
            print_r($value);
        }
    }
    
    public function ActionIndex()
    {
        Request::Initial()->Redirect('blogs/all');
    }
}
?>
