<?php if (!defined('INDIRECT')) die();
// TODO: Implement base Model class
abstract class Model
{
    protected $_properties = array();
    protected $_errors = array();
    
    protected function Rules()
    {
        return array();
    }
    
    protected function Messages()
    {
        return array();
    }
 
    public function Errors()
    {
        $error_messages = $this->Messages();
        
        foreach ($this->_properties as $property)
            $this->_errors[$property] = array();
        
        foreach ($this->Rules() as $name => $value)
        {
            if (is_array($value) && count($value) > 0)
            {
                foreach ($value as $rule_name => $rule_attribute)
                {
                    // TODO: I could create some type of standard validation
                    // class to handle these pre-specified rules. For simplicity sake,
                    // I'm just doing it in a switch for now.
                    switch ($rule_name)
                    {
                        case 'min_length':
                            $error = false;
                            
                            if (is_string($this->$name)
                                && strlen($this->$name) < $rule_attribute)
                                $error = true;
                            else if (is_array($this->$name)
                                && count($this->$name) < $rule_attribute)
                                $error = true;
                            
                            // TODO: Handle other types?
                            
                            if ($error)
                            {
                                if (array_key_exists($name, $error_messages)
                                    && is_array($error_messages[$name]) &&
                                    array_key_exists('min_length', $error_messages[$name]))
                                {
                                    $this->_errors[$name]['min_length'] = $error_messages[$name]['min_length'];
                                }
                            }
                            break;
                            
                        case 'max_length':
                            $error = false;
                            
                            if (is_string($this->$name)
                                && strlen($this->$name) > $rule_attribute)
                                $error = true;
                            else if (is_array($this->$name)
                                && count($this->$name) > $rule_attribute)
                                $error = true;
                            
                            // TODO: Handle other types?
                            
                            if ($error)
                            {
                                if (array_key_exists($name, $error_messages)
                                    && is_array($error_messages[$name]) &&
                                    array_key_exists('max_length', $error_messages[$name]))
                                {
                                    $this->_errors[$name]['max_length'] = $error_messages[$name]['max_length'];
                                }
                            }
                            break;
                    }
                }
            }
        }
        
        return $this->_errors;
    }
    
    function __construct($properties = array())
    {
        // Only copy properties that are in our ruleset. Ignore all other values
        foreach ($this->Rules() as $name => $value)
        {
            if (array_key_exists($name, $properties))
            {
                $this->$name = $properties[$name];
            }
        }
    }
    
    function __get($name)
    {
        if (array_key_exists($name, $this->_properties))
        {
            return $this->_properties[$name];
        }
        return null;
    }
    
    function __set($name, $value)
    {
        $this->_properties[$name] = $value;
    }
}
?>
