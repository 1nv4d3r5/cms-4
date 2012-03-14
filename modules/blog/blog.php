<?php if (!defined('INDIRECT')) die();

class Blog
{
    protected static $initialized = false;
    
    public static function Init()
    {
        if (!Blog::$initialized)
        {
            // Define blog pages before dynamic page routes are generated. This prevents
            // any page from overriding any default route.
            $blog_page = Database::current()
                            ->Query('SELECT `cms_pages`.`published`,`cms_pages`.`module_id` FROM '
                                . '`cms_pages` JOIN `cms_modules` ON '
                                . '`cms_pages`.`module_id`=`cms_modules`.`module_id` LIMIT 1')
                            ->Fetch();

            if (!$blog_page)
                throw new Exception('Blog module has not been correctly configured.');

            if ($blog_page['published'])
            {
                // public routes
                Route::RegisterController('ControllerBlog', 'blog');
                Route::Set('blog_entry', 'blog/entry/(?<slug>[^/]+)', 'ControllerBlog', 'ActionEntry');
                Route::Set('blog_entries', 'blog/entries', 'ControllerBlog', 'ActionEntries');
                Route::Set('blog', 'blog', 'ControllerBlog');
            }

            // admin/blog routes
            Route::RegisterController('ControllerAdminBlog', 'admin/blog');
            Route::Set('admin_blog', 'admin/blog', 'ControllerAdminBlog');
            Route::Set('admin_blog_list', 'admin/blog/list(/status/(?<status>[^/]+))?', 'ControllerAdminBlog', 'ActionList');
            Route::Set('admin_blog_new', 'admin/blog/new(/status/(?<status>[^/]+))?', 'ControllerAdminBlog', 'ActionNew');
            Route::Set('admin_blog_new_save', 'admin/blog/new/save', 'ControllerAdminBlog', 'ActionNewSave');
            Route::Set('admin_blog_edit', 'admin/blog/edit/(?<blog_entry_id>[1-9]{1}[0-9]*)(/status/(?<status>[^/]+))?', 'ControllerAdminBlog', 'ActionEdit');
            Route::Set('admin_blog_edit_save', 'admin/blog/edit/(?<blog_entry_id>[1-9]{1}[0-9]*)/save', 'ControllerAdminBlog', 'ActionEditSave');
            
            Blog::$initialized = true;
        }
    }
}
?>
