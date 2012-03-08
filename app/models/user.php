<?php if (!defined('INDIRECT')) die();
class User extends Model
{
    protected function Rules()
    {
        return array(
            'user_id' => array(),
            'username' => array(
                    'regex'  => '/[a-zA-Z0-9]+/',
                    'min_length' => 3,
                    'max_length' => 30,
                ),
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
            );
    }
}
?>
