<?php if (!defined('INDIRECT')) die();

// We're using the main template
ControllerTemplate::Load('main');

class ControllerBlog extends ControllerMain
{
    public function ActionEntry()
    {
        // echo 'Blog entry #' . $this->request->parameter('entry_id');
        $entry = Database::$current
                     ->Query('SELECT * FROM `cms_blog_entries` WHERE `slug`=\''
                         . $this->request->parameter('slug') . '\' LIMIT 1')
                     ->Fetch();
        
        if ($entry)
        {
            $this->template->Variables(array(
                    'page_title' => $entry['title'],
                    'content' => $entry['content'],
                ));
        }
    }
    
    public function ActionEntries()
    {
        $entries = Database::$current
                       ->Query('SELECT * FROM `cms_blog_entries` ORDER BY `date_created` DESC')
                       ->FetchArray();
        
        foreach ($entries as $key => $entry)
        {
            // TODO: Load real date settings from settings table.
            $entries[$key]['date_created'] = date('F d, Y',
                strtotime($entry['date_created']));
        }
        
        $this->template->Variables(array(
                'page_title' => 'Blog Entries',
                'content' => View::Factory('blog/entries', array(
                        'entries' => $entries,
                    )),
            ));
    }
    
    public function ActionIndex()
    {
        Request::Initial()->Redirect('blog/entries');
    }
}
?>
