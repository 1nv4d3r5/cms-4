<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<form action="<?php echo URL::Absolute('admin/blog/edit/' . $blog_entry['blog_entry_id'] . '/save'); ?>"
    method="post" style="margin-top: 15px;" id="edit_form">
    <input name="title" class="page-title" type="text" value="<?php echo $blog_entry['title']; ?>"/>
    <textarea name="content" class="mceAdvanced" style="width: 600px; height: 400px;"
        ><?php echo $blog_entry['content']; ?></textarea>
    <div class="admin-section-menu">
        <a href="javascript:void(0);" class="button" style="float: left; width: 140px;"
            onclick="document.getElementById('edit_form').submit(); return false;">
            <img src="<?php echo URL::Absolute('media/img/page-edit.png'); ?>"/>
            <div>Save Changes</div>
        </a>
    </div>
    <input type="hidden" name="save" value="true"/>
</form>
