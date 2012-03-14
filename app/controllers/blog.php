<?php if (!defined('INDIRECT')) die();

// We're using the main template
ControllerTemplate::Load('main');

class ControllerBlog extends ControllerMain
{
    public function ActionIndex()
    {
        Request::Initial()->Redirect('blog/entries');
    }
    
    public function ActionEntry()
    {
        $entry = Database::current()
                     ->Query('SELECT * FROM `cms_blog_entries` WHERE `slug`=\''
                         . $this->request->parameter('slug') . '\' AND '
                         . '`published`=1 LIMIT 1')
                     ->Fetch();
        
        // Entry doesn't exist or isn't published
        if (!$entry)
            $this->request->Redirect('blog/entries');
        
        $this->template->Variables(array(
                'page_title' => $entry['title'],
                'content'    => $entry['content'],
            ));
    }
    
    public function ActionEntries()
    {
        $entries = Database::current()
                       ->Query('SELECT * FROM `cms_blog_entries` '
                           . 'WHERE `published`=1 ORDER BY `date_created` DESC')
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
}
?>
