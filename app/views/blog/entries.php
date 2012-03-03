<?php if (!defined('INDIRECT')) die();

foreach ($entries as $entry):
?>
<div class="blog_entry">
    <h4>
        <a class="blog_entry_title" href="<?php echo URL::Absolute('blog/entry/' . $entry['slug']); ?>">
        <?php echo $entry['title']; ?>
    </a> <span class="blog_entry_date"><?php echo $entry['date_created']; ?></span>
    </h4>
    <div class="blog_entry_content"><?php echo $entry['content']; ?></div>
</div>
<?php endforeach; ?>

