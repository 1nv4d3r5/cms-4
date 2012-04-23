<?php if (!defined('INDIRECT')) die(); ?>

<h3>
    Delete user <?php echo $delete_user['username']; ?>? All user data belonging
    to this user will be deleted (blog entries, pages, history, etc.) This
    action cannot be undone.
</h3>
<a href="<?php echo URL::Absolute('admin/user');?>"
    class="button" style="float: left; width: 100px;">
    <img src="<?php echo URL::Absolute('media/img/arrow-undo.png'); ?>"/>
    <div>Cancel</div>
</a>
<a href="<?php echo URL::Absolute('admin/user/delete/' . $delete_user['user_id']
    . '/confirmed');?>"
    class="button" style="float: left; width: 100px;">
    <img src="<?php echo URL::Absolute('media/img/user-delete.png'); ?>"/>
    <div>Delete</div>
</a>