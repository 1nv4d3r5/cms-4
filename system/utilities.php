<?php

function Slug($name)
{
    return implode('-', explode(' ', strtolower(preg_replace('/[^a-z0-9 ]/i', '', $name))));
}
?>
