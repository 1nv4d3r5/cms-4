<?php if (!defined('INDIRECT')) die();
class User extends Model
{
    protected function Rules()
    {
        return array(
            'user_id' => array(),
            'username' => array(
                    array('regex', array('/[a-zA-Z0-9]+/')),
                    array('min_length', array(3)),
                    array('max_length', array(30)),
                ),
            'password' => array(
                    array('not_null'),
                ),
            'email' => array(
                    array('email'),
                ),
            'first_name' => array(),
            'last_name' => array(),
        );
    }
    
    protected function Messages()
    {
        return array(
                'username' => array(
                        'regex' => 'Username must be alphnumeric.',
                        'min_length' => 'Username must be three or more characters long.',
                        'max_length' => 'Username must be less than 30 characters long.',
                    ),
                'password' => array('not_null', 'Password must not be empty.'),
            );
    }
}
?>
