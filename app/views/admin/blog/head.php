<?php if (!defined('INDIRECT')) die(); ?>
<script language="javascript" type="text/javascript" src="<?php echo URL::Absolute('media/js/tiny_mce/tiny_mce.js'); ?>"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
    theme : "advanced",
    mode : "textareas",
    editor_selector : 'mceAdvanced',
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left"
});
</script>