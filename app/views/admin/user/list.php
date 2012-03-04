<?php if (!defined('INDIRECT')) die(); ?>
<?php if (count($users) > 0): ?>
    <table style="width: 100%; margin-top: 15px;">
        <!--tr>
            <td><input type="checkbox"/></td>
            <td style="font-weight: bold; font-size: 1.4em;">Username</td>
            <td style="font-weight: bold; font-size: 1.4em;">Actions</td>
        </tr-->
        <?php foreach ($users as $user): ?>
        <tr>
            <!--td><input type="checkbox"/></td-->
            <td>
                <a href="<?php echo URL::Absolute('admin/user/edit/' . $user['user_id']);?>"
                    style="font-size: 1.4em; font-weight: bold;">
                    <?php echo $user['username']; ?>
                </a>
            </td>
            <td>
                <a href="<?php echo URL::Absolute('admin/user/edit/' . $user['user_id']);?>"
                    class="button" style="float: left; width: 80px;">
                    <img src="<?php echo URL::Absolute('media/img/user-edit.png'); ?>"/>
                    <div>Edit</div>
                </a>
                <a href="<?php echo URL::Absolute('admin/user/delete/' . $user['user_id']);?>"
                    class="button" style="float: left; width: 100px;">
                    <img src="<?php echo URL::Absolute('media/img/user-delete.png'); ?>"/>
                    <div>Delete</div>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <!--tr>
            <td colspan="3">
                <div style="font-weight: bold; font-size: 1.1em; float: left; margin: 7px 7px 0 0;">With selected</div>
                <a href="javascript:void(0);" class="button" style="float: left; width: 100px;">
                    <img src="<?php echo URL::Absolute('media/img/user-delete.png'); ?>"/>
                    <div>Delete</div>
                </a>
            </td>
        </tr-->
    </table>
<?php else: ?>
    <h3>No users.</h3>
<?php endif; ?>
    <div class="user-menu">
        <a href="<?php echo URL::Absolute('admin/user/new');?>"
            class="button" style="float: left; width: 90px;">
            <img src="<?php echo URL::Absolute('media/img/user-add.png'); ?>"/>
            <div>New</div>
        </a>
    </div>