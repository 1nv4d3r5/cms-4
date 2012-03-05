<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<?php if (isset($pages) && count($pages) > 0): ?>
    <ul class="admin-user-list">
        <?php foreach ($pages as $list_page): ?>
            <li>
                <div style="width: 320px; overflow-x: hidden; display: inline-block; vertical-align: top; padding-top: 4px;">
                    <a href="<?php echo URL::Absolute('admin/page/edit/' . $list_page['page_id']);?>"
                        style="font-size: 1.4em; font-weight: bold; vertical-align: middle;">
                        <?php if ($list_page['default']): ?>
                            <img src="<?php echo URL::Absolute('media/img/page-default.png'); ?>"
                                 style="width: 22px; height: 22px;"/>
                        <?php endif; ?>
                        <?php echo $list_page['title']; ?>
                    </a>
                </div>
                <div style="display: inline-block;">
                    <a href="<?php echo URL::Absolute('admin/page/edit/' . $list_page['page_id']);?>"
                        class="button" style="float: left; width: 80px;">
                        <img src="<?php echo URL::Absolute('media/img/page-edit.png'); ?>"/>
                        <div>Edit</div>
                    </a>
                    <?php if ($list_page['published']): ?>
                        <a href="<?php echo URL::Absolute('admin/page/unpublish/' . $list_page['page_id']);?>"
                            class="button" style="float: left; width: 115px;">
                            <img src="<?php echo URL::Absolute('media/img/page-unpublish.png'); ?>"/>
                            <div>Unpublish</div>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URL::Absolute('admin/page/publish/' . $list_page['page_id']);?>"
                            class="button" style="float: left; width: 100px;">
                            <img src="<?php echo URL::Absolute('media/img/page-publish.png'); ?>"/>
                            <div>Publish</div>
                        </a>
                    <?php endif; ?>
                    <?php if ($list_page['deletable']): ?>
                        <a href="<?php echo URL::Absolute('admin/page/delete/' . $list_page['page_id']);?>"
                            class="button" style="float: left; width: 100px;">
                            <img src="<?php echo URL::Absolute('media/img/page-delete.png'); ?>"/>
                            <div>Delete</div>
                        </a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <h3>No pages.</h3>
<?php endif; ?>
<?php if ($user['permission_pages_add']): ?>
    <div class="admin-section-menu">
        <a href="<?php echo URL::Absolute('admin/page/new');?>"
            class="button" style="float: left; width: 90px;">
            <img src="<?php echo URL::Absolute('media/img/page-add.png'); ?>"/>
            <div>New</div>
        </a>
    </div>
<?php endif; ?>