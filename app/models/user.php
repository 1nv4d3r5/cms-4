<?php if (!defined('INDIRECT')) die();
class User extends Model
{
    protected function Rules()
    {
        return array
        (
            'user_id' => array(
                    array('RegEx', array('/^[0-9]*$/'))
                ),
            'username' => array(
                    array('RegEx', array('/^[a-zA-Z0-9]+$/')),
                    array('MinLength', array(3)),
                    array('MaxLength', array(30)),
                ),
            'password' => array(
                    array('NotEmpty'),
                ),
            'email' => array(
                    array('NotEmpty'),
                    array('Email'),
                ),
            'first_name' => array(
                    array('RegEx', array('/^[a-zA-Z]*$/')),
                ),
            'last_name' => array(
                    array('RegEx', array('/^[a-zA-Z]*$/')),
                ),
        );
    }
    
    protected function Messages()
    {
        return array
        (
            'username' => array(
                    'RegEx' => 'Username must be alphnumeric.',
                    'MinLength' =>
                        'Username must be three or more characters long.',
                    'MaxLength' =>
                        'Username must be less than 30 characters long.',
                ),
            'password' => array(
                    'NotEmpty' => 'Password must not be empty.'
                ),
            'email' => array(
                    'NotEmpty' => 'Email must not be empty.'
                ),
        );
    }
}
?>
