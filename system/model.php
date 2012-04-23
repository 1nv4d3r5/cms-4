<?php if (!defined('INDIRECT')) die();
// TODO: Implement base Model class
class Validate
{
    public static function Email($value)
    {
        // TODO: Implement email validation.
        return true;
    }
    
    public static function RegEx($value, $pattern)
    {
        return (bool)preg_match($pattern, $value);
    }
    
    public static function MaxLength($value, $length)
    {
        return strlen($value) <= $length;
    }
    
    public static function MinLength($value, $length)
    {
        return strlen($value) >= $length;
    }
    
    public static function NotEmpty($value)
    {
        return !empty($value);
    }
}

class Model
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
    
    public function Validate()
    {
        $validated = true;
        $error_messages = $this->Messages();
        $this->_errors = array();
        
        foreach ($this->Rules() as $field_name => $rules)
        {
            $this->_errors[$field_name] = array();
            
            foreach ($rules as $rule)
            {
                $success = false;
                $rule_args = array();
                $error_name = null;
                
                if (count($rule) > 1)
                    list($rule_name, $rule_args) = $rule;
                else
                    list($rule_name) = $rule;

                // Add field value to the front of the parameter list
                array_unshift($rule_args, $this->$field_name);

                /* $rule_name in the form of the following:
                * array(obj, 'method')
                * array('Class', 'method')
                */
                if (is_array($rule_name))
                {
                    list($rule_object, $rule_method) = $rule_name;
                    $error_name = $rule_method;
                    $reflection = new ReflectionMethod($rule_object,
                            $rule_method);
                    $success = $reflection->invokeArgs(is_object($rule_object) ?
                        $rule_object : NULL, $rule_args);
                }
                /* $rule_name in the form of the following:
                * 'method'
                */
                else if (is_string($rule_name) && method_exists('Validate',
                        $rule_name))
                {
                    // $rule_name is really rule_method
                    $error_name = $rule_name;
                    $reflection = new ReflectionMethod('Validate', $rule_name);
                    $success = $reflection->invokeArgs(NULL, $rule_args);
                }
                // global or lambda function
                else if (is_callable($rule_name))
                {
                    $reflection = new ReflectionFunction($rule_name);
                    $success = $reflection->invokeArgs($rule_args);
                }
                else
                {
                    // Unhandled check.
                    throw new Exception('Uknown validation method in model.');
                }
                
                if (!$success)
                {
                    // Not successful, find appropriate error message if
                    // possible. If no error message exists for the given
                    // error_name, we'll just assign error_name.
                    $validated = false;
                    if (array_key_exists($field_name, $error_messages))
                    {
                        if (array_key_exists($error_name,
                                $error_messages[$field_name]))
                            $this->_errors[$field_name][$error_name] =
                                $error_messages[$field_name][$error_name];
                        else
                            $this->_errors[$field_name][$error_name] = null;
                    }
                    else
                    {
                        $this->_errors[$field_name][$error_name] = null;
                    }
                }
            }
        }
        
        return $validated;
    }
 
    public function errors()
    {
        return $this->_errors;
    }
    
    function __construct($properties = array())
    {
        // Only copy properties that are in our ruleset. Ignore all other values
        foreach ($this->Rules() as $name => $value)
        {
            if (array_key_exists($name, $properties))
                $this->$name = $properties[$name];
            else
                $this->$name = null;
        }
    }
    
    function __get($name)
    {
        if (array_key_exists($name, $this->_properties))
            return $this->_properties[$name];
        
        // Properties must be registered.
        throw new Exception('Unknown property selected for model.');
    }
    
    function __set($name, $value)
    {
        $this->_properties[$name] = $value;
    }
}
?>
