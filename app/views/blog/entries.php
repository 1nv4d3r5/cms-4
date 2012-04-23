<?php if (!defined('INDIRECT')) die();

foreach ($entries as $entry):
?>
<div class="blog_entry">
    <h4>
        <a class="blog_entry_title" href="<?php echo URL::Absolute('blog/entry/'
                . $entry['slug']); ?>">
        <?php echo $entry['title']; ?>
        </a>
        <?php if (isset($user) && $user &&
                $user['permission_blog_entry_edit']): ?>
        <a href="<?php echo URL::Absolute('admin/blog/edit/'
                . $entry['blog_entry_id']); ?>">Edit</a>
        <?php endif; ?>
        <span class="blog_entry_date">
            <?php echo $entry['date_created']; ?> by
            <?php echo $entry['user']['username']; ?>
        </span>
    </h4>
    <div class="blog_entry_content">
        <?php echo $entry['content']; ?>
        <?php if (isset($entry['last_user']) && $entry['last_user']): ?>
            Last edited by <?php echo $entry['last_user']['username']; ?>
            on <?php echo date('F d, Y',
                    strtotime($entry['last_user']['date'])) ?>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>

