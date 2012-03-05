<?php if (!defined('INDIRECT')) die(); ?>
<form action="<?php echo URL::Absolute('admin/page/edit/' . $page['page_id'] . '/save'); ?>"
    method="post" style="margin-top: 15px;">
    <input class="page-title" type="text" value="<?php echo $page['title']; ?>"/>
    <textarea class="mceAdvanced" style="width: 600px; height: 400px;"
        ><?php echo $page['content']; ?></textarea>
    <div class="admin-section-menu">
        <a href="<?php echo URL::Absolute('admin/page/save/' . $page['page_id']);?>"
            class="button" style="float: left; width: 140px;">
            <img src="<?php echo URL::Absolute('media/img/page-edit.png'); ?>"/>
            <div>Save Changes</div>
        </a>
    </div>
</form>
