<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<?php if (isset($blog_entries) && count($blog_entries) > 0): ?>
    <ul class="admin-user-list">
        <?php foreach ($blog_entries as $list_entry): ?>
            <li>
                <div style="width: 320px; overflow-x: hidden;
                    display: inline-block; vertical-align: top;
                    padding-top: 4px;">
                    <a href="<?php echo URL::Absolute('admin/blog/edit/'
                        . $list_entry['blog_entry_id']);?>"
                        style="font-size: 1.4em; font-weight: bold;
                        vertical-align: middle;">
                        <?php echo $list_entry['title']; ?>
                    </a>
                </div>
                <div style="display: inline-block;">
                    <?php if (isset($list_entry['editable']) &&
                              $list_entry['editable'] && $user['permission_blog_entry_edit']): ?>
                        <a href="<?php echo URL::Absolute('admin/blog/edit/'
                                . $list_entry['blog_entry_id']);?>"
                            class="button" style="float: left; width: 80px;">
                            <img src="<?php echo URL::Absolute(
                                    'media/img/page-edit.png'); ?>"/>
                            <div>Edit</div>
                        </a>
                    <?php endif; ?>
                    <?php if (isset($list_entry['published']) &&
                            $list_entry['published']): ?>
                        <a href="<?php echo URL::Absolute(
                                'admin/blog/unpublish/' 
                                . $list_entry['blog_entry_id']);?>"
                            class="button" style="float: left; width: 115px;">
                            <img src="<?php echo URL::Absolute(
                                    'media/img/page-unpublish.png'); ?>"/>
                            <div>Unpublish</div>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URL::Absolute('admin/blog/publish/'
                                . $list_entry['blog_entry_id']);?>"
                            class="button" style="float: left; width: 100px;">
                            <img src="<?php echo URL::Absolute(
                                    'media/img/page-publish.png'); ?>"/>
                            <div>Publish</div>
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo URL::Absolute('admin/blog/delete/'
                            . $list_entry['blog_entry_id']);?>"
                        class="button" style="float: left; width: 100px;">
                        <img src="<?php echo URL::Absolute(
                                'media/img/page-delete.png'); ?>"/>
                        <div>Delete</div>
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <h3>No blog entries.</h3>
<?php endif; ?>
<?php if ($user['permission_blog_entry_add']): ?>
    <div class="admin-section-menu">
        <a href="<?php echo URL::Absolute('admin/blog/new');?>"
            class="button" style="float: left; width: 90px;">
            <img src="<?php echo URL::Absolute('media/img/page-add.png'); ?>"/>
            <div>New</div>
        </a>
    </div>
<?php endif; ?>