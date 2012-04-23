<?php if (!defined('INDIRECT')) die(); ?>

<h3>
    Delete page <?php echo $page['title']; ?>? This action cannot be undone.
</h3>
<a href="<?php echo URL::Absolute('admin/page');?>"
    class="button" style="float: left; width: 100px;">
    <img src="<?php echo URL::Absolute('media/img/arrow-undo.png'); ?>"/>
    <div>Cancel</div>
</a>
<a href="<?php echo URL::Absolute('admin/page/delete/' . $page['page_id']
    . '/confirmed');?>"
    class="button" style="float: left; width: 100px;">
    <img src="<?php echo URL::Absolute('media/img/page-delete.png'); ?>"/>
    <div>Delete</div>
</a>