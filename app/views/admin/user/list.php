<?php if (!defined('INDIRECT')) die(); ?>
<?php if (count($users) > 0): ?>
    <table>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td>
                <a href="<?php echo URL::Absolute('admin/user/edit/' . $user['user_id']);?>">
                    <?php echo $user['username']; ?>
                </a>
            </td>
            <td><a href="<?php echo URL::Absolute('admin/user/delete/' . $user['user_id']); ?>">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h3>No users.</h3>
<?php endif; ?>
