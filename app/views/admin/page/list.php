<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<?php if (isset($pages) && count($pages) > 0): ?>
    <ul class="admin-user-list">
        <?php for ($i = 0; $i < count($pages); ++$i): ?>
            <li>
                <div style="width: 210px; overflow-x: hidden;
                    display: inline-block; vertical-align: top;
                    padding-top: 4px;">
                    <a href="<?php echo URL::Absolute('admin/page/edit/'
                        . $pages[$i]['page_id']);?>"
                        style="font-size: 1.4em; font-weight: bold;
                        vertical-align: middle;">
                        <?php if ($pages[$i]['default']): ?>
                            <img src="<?php echo URL::Absolute(
                                 'media/img/page-default.png'); ?>"
                                 style="width: 22px; height: 22px;"/>
                        <?php endif; ?>
                        <?php echo $pages[$i]['title']; ?>
                    </a>
                </div>
                <div style="display: inline-block;">
                    <?php if ($i > 0): ?>
                        <a href="<?php echo URL::Absolute(
                            'admin/page/move/'
                            . $pages[$i]['page_id']
                            . '/' . $pages[$i - 1]['page_id']); ?>"
                            class="button"
                            style="float: left; width: 30px;">
                            <img src="<?php echo URL::Absolute(
                                'media/img/page-up.png'); ?>"/>
                        </a>
                    <?php endif; ?>
                    <?php if ($i + 1 < count($pages)): ?>
                        <a href="<?php echo URL::Absolute(
                            'admin/page/move/'
                            . $pages[$i]['page_id']
                            . '/' . $pages[$i + 1]['page_id']); ?>"
                            class="button"
                            style="float: left; width: 30px;">
                            <img src="<?php echo URL::Absolute(
                                'media/img/page-down.png'); ?>"/>
                        </a>
                    <?php endif; ?>
                    <?php if ($pages[$i]['editable']): ?>
                        <a href="<?php echo URL::Absolute('admin/page/edit/'
                            . $pages[$i]['page_id']);?>"
                            class="button" style="float: left; width: 80px;">
                            <img src="<?php echo URL::Absolute(
                                'media/img/page-edit.png'); ?>"/>
                            <div>Edit</div>
                        </a>
                    <?php endif; ?>
                    <?php if (!$pages[$i]['default']): ?>
                        <?php if ($pages[$i]['published']): ?>
                            <a href="<?php echo URL::Absolute(
                                'admin/page/unpublish/'
                                . $pages[$i]['page_id']);?>"
                                class="button"
                                style="float: left; width: 115px;">
                                <img src="<?php echo URL::Absolute(
                                    'media/img/page-unpublish.png'); ?>"/>
                                <div>Unpublish</div>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo URL::Absolute(
                                'admin/page/publish/'
                                . $pages[$i]['page_id']);?>"
                                class="button"
                                style="float: left; width: 100px;">
                                <img src="<?php echo URL::Absolute(
                                    'media/img/page-publish.png'); ?>"/>
                                <div>Publish</div>
                            </a>
                        <?php endif; ?>
                        <?php if ($pages[$i]['deletable']): ?>
                            <a href="<?php echo URL::Absolute(
                                'admin/page/delete/'
                                . $pages[$i]['page_id']);?>"
                                class="button"
                                style="float: left; width: 100px;">
                                <img src="<?php echo URL::Absolute(
                                    'media/img/page-delete.png'); ?>"/>
                                <div>Delete</div>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>
        <?php endfor; ?>
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