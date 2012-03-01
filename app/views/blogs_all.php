<?php if (!defined('INDIRECT')) die(); ?>

<?php foreach ($entries as $entry): ?>
<div>
    <h3><?php echo $entry['title']; ?></h3>
    <p><?php echo $entry['content']; ?></p>
</div>
<?php endforeach; ?>
