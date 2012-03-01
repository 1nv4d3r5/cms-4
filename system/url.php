<?php if (!defined('INDIRECT')) die();
class URL
{
    public static function Absolute($uri = '', $protocol = 'http')
    {
        $hostname = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] 
            : $_SERVER['SERVER_NAME'];
        
        return $protocol . '://' . $hostname . CMS::base_url() . trim($uri, '/');
    }
}
?>
