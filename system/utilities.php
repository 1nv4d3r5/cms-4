<?php

function Slug($name)
{
    return implode(explode(strtolower($name), ' '), '-');
}
?>
