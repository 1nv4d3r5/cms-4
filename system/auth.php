<?php if (!defined('INDIRECT')) die();

class Auth
{
    protected $cookie_name = 'cms_auth';
    protected $user = null;
            
    public static function Factory()
    {
        return new Auth;
    }
    
    public function cookie_name($cookie_name = null)
    {
        if ($cookie_name === null)
            return $this->cookie_name;
        
        // Delete old cookie (preserving value) and store value in new cookie
        if (isset($_COOKIE[$this->cookie_name]))
        {
            // TODO: Because setcookie also sets header information, cookies should
            // not actually be set here. To fix this, a cookie library must be
            // made that will come into play when the response is being rendered.
            $old_cookie = $_COOKIE[$this->cookie_name];
            setcookie($this->cookie_name, '', time() - 86400);
            setcookie($cookie_name, $old_cookie, time() + 86400);
        }
        
        $this->cookie_name = $cookie_name;
        
        return $this;
    }
    
    public function user($user = null)
    {
        if ($user === null)
        {
            // Does user exist?
            if ($this->user === null)
            {
                if (isset($_COOKIE[$this->cookie_name]))
                {
                    // Check auth cookie
                    if (strlen($_COOKIE[$this->cookie_name]) == 80)
                    {
                        $auth_query = Database::current()
                                          ->Query("SELECT `user_id` FROM `cms_auth` "
                                              . "WHERE `cookie`='" 
                                              . Database::current()->Escape($_COOKIE[$this->cookie_name])
                                              . "' LIMIT 1", $db);
                        
                        $this->user = $auth_query->Fetch();
                        
                        if ($this->user)
                            // Update cookie to expire 24 hours from now
                            setcookie($this->cookie_name, $_COOKIE[$this->cookie_name], time() + 36400);
                        else
                            setcookie($this->cookie_name, '', time() - 86400, "/");
                    }
                    else
                    {
                        // Remove cms_auth cookie since it's invalid.
                        setcookie($this->cookie_name, '', time() - 86400, "/");
                    }
                }
            }
            
            return $this->user;
        }
        
        $this->user = $user;
        
        return $this;
    }
}
?>
