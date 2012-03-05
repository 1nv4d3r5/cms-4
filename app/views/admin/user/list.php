<?php if (!defined('INDIRECT')) die(); ?>
<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<?php endif; ?>
<?php if (count($users) > 0): ?>
    <ul class="admin-user-list">
        <?php foreach ($users as $user): ?>
            <li>
                <div style="width: 100px; overflow-x: hidden; display: inline-block; vertical-align: top; padding-top: 4px;">
                    <a href="<?php echo URL::Absolute('admin/user/edit/' . $user['user_id']);?>"
                        style="font-size: 1.4em; font-weight: bold; vertical-align: middle;"><?php echo $user['username']; ?></a>
                </div>
                <div style="display: inline-block;">
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
                    
                    <?php if ($user['archived']): ?>
                        <a href="<?php echo URL::Absolute('admin/user/unarchive/' . $user['user_id']);?>"
                            class="button" style="float: left; width: 115px;">
                            <img src="<?php echo URL::Absolute('media/img/user-unarchive.png'); ?>"/>
                            <div>Unarchive</div>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URL::Absolute('admin/user/archive/' . $user['user_id']);?>"
                            class="button" style="float: left; width: 100px;">
                            <img src="<?php echo URL::Absolute('media/img/user-archive.png'); ?>"/>
                            <div>Archive</div>
                        </a>
                    <?php endif ?>
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