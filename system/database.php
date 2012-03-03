<?php if (!defined('INDIRECT')) die();

class Database
{
    protected static $current = null;
    
    public $hostname = '';
    public $database = '';
    public $username = '';
    public $password = '';
    
    protected $link = null;
    protected $current_sql = '';
    
    function __construct($parameters = array())
    {
        foreach ($parameters as $key => $value)
        {
            if ($value !== null && property_exists('Database', $key))
            {
                $this->$key = $value;
            }
        }
    }
    
    public static function current()
    {
        return Database::$current;
    }
    
    public static function Factory($parameters = array(), $connect = true)
    {
        Database::$current = new Database($parameters);
        return ($connect) ? Database::$current->Connect() : Database::$current;
    }
    
    public function Escape($string)
    {
        return mysql_real_escape_string($string, $this->link);
    }
    
    public function Connect()
    {
        $this->link = mysql_connect($this->hostname, $this->username, $this->password);
        
        if (!$this->link || !mysql_select_db($this->database, $this->link))
            die(mysql_error());
        
        return $this;
    }
    
    public function Query($sql)
    {
        $this->current_sql = $sql;
        
        return $this;
    }
    
    public function Execute()
    {
        $query = null;
        if (strlen($this->current_sql) > 0)
            $query = mysql_query($this->current_sql, $this->link);
        
        return $query;
    }
    
    public function Fetch()
    {
        if (strlen($this->current_sql) > 0)
        {
            $query = mysql_query($this->current_sql, $this->link);
            
            if (!$query)
                die(mysql_error());
            
            if (mysql_num_rows($query) > 0)
                return mysql_fetch_assoc($query);
        }
        
        return null;
    }
    
    public function FetchArray()
    {
        if (strlen($this->current_sql) > 0)
        {
            $query = mysql_query($this->current_sql, $this->link);
            
            if ($query)
            {
                $result_array = array();
                while ($result = mysql_fetch_assoc($query))
                    $result_array[] = $result;
                return $result_array;
            }
        }
        
        return null;
    }
}

?>
