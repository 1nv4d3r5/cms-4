<?php
function Slug($name)
{
    $sanitized = strtolower(trim($name));
    $sanitized = preg_replace('/[^-_a-z0-9 \t]/i', '', $sanitized);
    return preg_replace('/[ \t]+/', '-', $sanitized);
}
?>
