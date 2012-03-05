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
            setcookie($this->cookie_name, '', time() - 86400, CMS::base_url());
            setcookie($cookie_name, $old_cookie, time() + 86400, CMS::base_url());
        }
        
        $this->cookie_name = $cookie_name;
        
        return $this;
    }
    
    public function Authenticate($username, $password)
    {
        $username = Database::current()->Escape(strtolower($username));
        $password = sha1($password);
        
        $user = Database::current()
                    ->Query("SELECT `user_id` FROM `cms_users` WHERE"
                        . " `username`='$username' AND `password`='$password' LIMIT 1")
                    ->Fetch();
        
        if ($user)
        {
            $cookie_value = sha1(rand()) . sha1(rand());
            
            if (Database::current()
                    ->Query("INSERT INTO `cms_auth`(`user_id`,`cookie`)"
                        . " VALUES({$user['user_id']}, '$cookie_value')")
                    ->Execute())
            {
                // Set auth session for 1 day (24 hours)
                setcookie($this->cookie_name(), $cookie_value, time() + 36400, CMS::base_url());
            }
            else
                // Database error occurred.
                throw new Exception();
        }
        
        return $user;
    }
    
    public function Deauthenticate()
    {
        if ($this->user())
        {
            $user = $this->user();
            if (!Database::current()
                     ->Query("DELETE FROM `cms_auth` WHERE `user_id`='"
                        . $user['user_id'] . "'")
                     ->Execute())
                // MySQL error
                throw new Exception();
            
            setcookie($this->cookie_name, '', time() - 86400, CMS::base_url());
            
            $this->user = null;
        }
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
                        $this->user = Database::current()
                                          ->Query("SELECT * FROM `cms_auth` "
                                              . "JOIN `cms_users` "
                                              . "ON `cms_auth`.`user_id`=`cms_users`.`user_id` "
                                              . "WHERE `cms_auth`.`cookie`='" 
                                              . Database::current()->Escape($_COOKIE[$this->cookie_name])
                                              . "' LIMIT 1")
                                          ->Fetch();
                        
                        if ($this->user)
                            // Update cookie to expire 24 hours from now
                            setcookie($this->cookie_name, $_COOKIE[$this->cookie_name], time() + 36400, CMS::base_url());
                        else
                            setcookie($this->cookie_name, '', time() - 86400, CMS::base_url());
                    }
                    else
                    {
                        // Remove cms_auth cookie since it's invalid.
                        setcookie($this->cookie_name, '', time() - 86400, CMS::base_url());
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
