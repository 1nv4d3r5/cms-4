<?php if (!defined('INDIRECT')) die();
// TODO: Make a table-less layout for editing a user.
?>

<?php if (isset($status_message)): ?>
    <h3><?php echo $status_message; ?></h3>
<? endif; ?>

<form action="<?php echo URL::Absolute('admin/user/edit/' . $edit_user['user_id'] . '/save'); ?>" method="post" id="edit_form">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" value="<?php echo $edit_user['username']; ?>"/></td>
        </tr>
        <tr>
            <td>New Password</td>
            <td><input type="password" name="password"/></td>
        </tr>
        <tr>
            <td>Confirm New Password</td>
            <td><input type="password" name="confirm_password"/></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="email" value="<?php echo $edit_user['email']; ?>"/></td>
        </tr>
        <tr>
            <td>First Name</td>
            <td><input type="text" name="first_name" value="<?php echo $edit_user['first_name']; ?>"/></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" name="last_name" value="<?php echo $edit_user['last_name']; ?>"/></td>
        </tr>
        <tr>
            <td>Manage Users</td>
            <td><input type="checkbox" name="permission_manage_users" value="true"
                <?php if ($edit_user['permission_manage_users'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td>Edit Pages</td>
            <td><input type="checkbox" name="permission_pages_edit" value="true"
                <?php if ($edit_user['permission_pages_edit'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td>Add Pages</td>
            <td><input type="checkbox" name="permission_pages_add" value="true"
                <?php if ($edit_user['permission_pages_add'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td>Edit Blog Entries</td>
            <td><input type="checkbox" name="permission_blog_entry_edit" value="true"
                <?php if ($edit_user['permission_blog_entry_edit'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td>Add Blog Entries</td>
            <td><input type="checkbox" name="permission_blog_entry_add" value="true"
                <?php if ($edit_user['permission_blog_entry_add'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td>Credit Blog Entries to Users</td>
            <td><input type="checkbox" name="permission_blog_entry_credit_users" value="true"
                <?php if ($edit_user['permission_blog_entry_credit_users'] == 1)
                    echo 'checked="checked"';
                ?>/></td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="javascript:void(0);" class="button login_button" 
                    onclick="document.getElementById('edit_form').submit(); return false;">
                    <img src="<?php echo URL::Absolute('media/img/user-edit.png'); ?>"/>
                    <div>Save Changes</div>
                </a>
            </td>
        </tr>
    </table>
    <input type="hidden" name="save" value="true"/>
</form>

