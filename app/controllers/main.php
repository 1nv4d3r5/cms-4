<?php if (!defined('INDIRECT')) die();
class ControllerMain extends ControllerTemplate
{
    public $template = 'main';
    
    public function Before()
    {
        parent::Before();
        
        // Generate menus for the page.
        $this->template->Variable('menu_items', 
            Database::current()
                ->Query("SELECT * FROM `cms_menu` JOIN `cms_pages` "
                    . "ON `cms_menu`.`page_id`=`cms_pages`.`page_id` "
                    . "WHERE `cms_pages`.`published`=1 "
                    . "ORDER BY `cms_menu`.`position` ASC;")
                ->FetchArray());
        
        $site_name = Database::current()
                          ->Query('SELECT `setting_value` FROM `cms_settings`'
                              . ' WHERE `setting_key`=\'site_name\' LIMIT 1')
                          ->Fetch();
        
        if ($site_name && isset($site_name['setting_value']))
            $site_name = $site_name['setting_value'];
        else
            $site_name = 'CMS';
        
        $this->template->Variables(array(
                'title'     => $site_name,
                'site_name' => $site_name,
            ));
    }
    
    public function ActionIndex()
    {
        $page = Database::current()
                    ->Query("SELECT * FROM `cms_pages` WHERE `default`=1")
                    ->Fetch();
        
        $this->request->Redirect($page['slug']);
    }
    
    public function ActionPage()
    {
        // Select page based on slug name.
        $page = Database::current()
                    ->Query("SELECT * FROM `cms_pages` WHERE `slug`='"
                        . $this->request->parameter('slug') . "' LIMIT 1")
                    ->Fetch();
        
        // Add template information based on page.
        $this->template->Variables(array(
            'page_title' => $page['title'], 
            'content' => $page['content'],));
    }
}
?>
