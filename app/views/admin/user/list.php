<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<?php if (isset($users) && count($users) > 0): ?>
    <ul class="admin-user-list">
        <?php foreach ($users as $list_user): ?>
            <li>
                <div style="width: 100px; overflow-x: hidden; display: inline-block; vertical-align: top; padding-top: 4px;">
                    <a href="<?php echo URL::Absolute('admin/user/edit/' . $list_user['user_id']);?>"
                        style="font-size: 1.4em; font-weight: bold; vertical-align: middle;"><?php echo $list_user['username']; ?></a>
                </div>
                <div style="display: inline-block;">
                    <a href="<?php echo URL::Absolute('admin/user/edit/' . $list_user['user_id']);?>"
                        class="button" style="float: left; width: 80px;">
                        <img src="<?php echo URL::Absolute('media/img/user-edit.png'); ?>"/>
                        <div>Edit</div>
                    </a>
                    
                    <?php // Don't show actions that a user can't do to themselves
                        if ($list_user['user_id'] != $user['user_id']): ?>
                        <a href="<?php echo URL::Absolute('admin/user/delete/' . $list_user['user_id']);?>"
                            class="button" style="float: left; width: 100px;">
                            <img src="<?php echo URL::Absolute('media/img/user-delete.png'); ?>"/>
                            <div>Delete</div>
                        </a>

                        <?php if ($list_user['archived']): ?>
                            <a href="<?php echo URL::Absolute('admin/user/unarchive/' . $list_user['user_id']);?>"
                                class="button" style="float: left; width: 115px;">
                                <img src="<?php echo URL::Absolute('media/img/user-unarchive.png'); ?>"/>
                                <div>Unarchive</div>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo URL::Absolute('admin/user/archive/' . $list_user['user_id']);?>"
                                class="button" style="float: left; width: 100px;">
                                <img src="<?php echo URL::Absolute('media/img/user-archive.png'); ?>"/>
                                <div>Archive</div>
                            </a>
                        <?php endif; ?>
                    <?php endif; /* $list_user['user_id'] != $user['user_id'] */ ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
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