<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<form action="<?php echo URL::Absolute('admin/page/new/save'); ?>"
    method="post" style="margin-top: 15px;" id="save_form">
    <input name="title" class="page-title" type="text"/>
    <textarea name="content" class="mceAdvanced"
        style="width: 600px; height: 400px;"></textarea>
    <div class="admin-section-menu">
        <a href="javascript:void(0);" class="button"
            style="float: left; width: 90px;"
            onclick="document.getElementById('save_form').submit();
                return false;">
            <img src="<?php echo URL::Absolute('media/img/page-add.png'); ?>"/>
            <div>Save</div>
        </a>
    </div>
    <input type="hidden" name="save" value="true"/>
</form>
