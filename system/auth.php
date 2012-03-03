<?php if (!defined('INDIRECT')) die();

class Auth
{
    protected $user;
            
    public static function Factory()
    {
        return new Auth;
    }
    
    public function user($user = null)
    {
        if ($user === null)
            return $this->user;
        
        $this->user = $user;
        
        return $this;
    }
}
?>
