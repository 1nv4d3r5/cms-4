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
            $entries[$key]['user'] = Database::current()
                           ->Query('SELECT `username` FROM `cms_users` '
                                   . ' WHERE `user_id`=\''
                                   . $entries[$key]['user_id'] . '\'')
                           ->Fetch();
            
            $entries[$key]['last_user'] = Database::current()
                    ->Query('SELECT `cms_blog_entry_history`.`user_id`,'
                            . '`username`,`action`,`date` '
                            . 'FROM `cms_blog_entry_history` '
                            . 'JOIN `cms_users` ON '
                            . '`cms_blog_entry_history`'
                            . '.`user_id`=`cms_users`.`user_id` '
                            . 'WHERE `blog_entry_id`=\''
                            . $entries[$key]['blog_entry_id'] . '\''
                            . ' AND `action`=\'edit\' '
                            . 'ORDER BY `cms_blog_entry_history`.`date` DESC '
                            . 'LIMIT 1')
                    ->Fetch();
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
