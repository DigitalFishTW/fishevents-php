<?php
class UserModel
{
    private $table = 'profile';
    
     
    function create($data)
    {
        return $GLOBALS['DB']->insert($this->table, $data);
    }
    
    
    function get($username, $field)
    {
        return $GLOBALS['DB']->where('username', $username)
                             ->getValue($this->table, $field);
    }
    
    function putProfile($data)
    {
        $data->clean('licenses, phones, day, month, year');
        
        return $GLOBALS['DB']->onDuplicate($data->outputKeys(), 'id')
                             ->insert($this->table, $data->output());
    }
    
    
    function getAll($username)
    {
        return $GLOBALS['DB']->where('username', $username)
                             ->get($this->table);
    }
    
    
    function changePassword($username, $password)
    {
        return $GLOBALS['DB']->where('username', $username)
                             ->update($this->table, ['password' => $password]);
    }
    
    
    function exists($username)
    {
        return $GLOBALS['DB']->where('username', $username)
                             ->has($this->table);
    }
}
?>