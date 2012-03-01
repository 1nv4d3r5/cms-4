<?php if (!defined('INDIRECT')) die();
class URL
{
    public static function absolute($uri = '', $protocol = 'http')
    {
        return $protocol . '://' . $_SERVER['HTTP_HOST'] 
                . CMS::base_url() . trim($uri, '/');
    }
}
?>
