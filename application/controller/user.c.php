<?php
class User
{
    function __construct()
    {
        include __DIR__ . '/../model/user.m.php';
        
        $this->model = new UserModel();
    }
    
    
    /**
     * Create
     * 
     * 建立一個使用者。
     * 
     * @param  stdClass $data
     * 
     * @return stdClass
     */
    
    function create($data)
    {
        /** 將密碼 MD5 加密（未來需更換更強的加密方式） */
        $data->password = md5($data->password);
        /** 隨機建立 64 字串作為私人 Token */
        $data->token    = Anything::generate(64);
        
        /** 新增使用者並取得使用者 Id */
        $data->userId   = $this->model->create($data->output());
        
        return $data;
    }
    
    
    
    
    /**
     * put
     */
    
    function putProfile($data)
    {
        $data->birth = $data->year . '-' . $data->month . '-' . $data->day;
        
        return $this->model->putProfile($data);
    }
    
    
    
    /**
     * Change Password
     * 
     * 更換密碼。
     * 
     * @param  stdClass $data
     */
    
    function changePassword($data)
    {
        /** 找不到使用者時回傳找不到使用者 */
        if(!$this->exists($data->username))
            return Aira::error('USER_NOT_EXISTED');
        
        /** 將新的密碼 MD5 加密（未來需更換更強的加密方式） */
        $data->password = md5($data->password);
        
        /** 轉交給資料庫更換新的密碼 */
        $this->model->changePassword($data->username, $data->password);
    }
    
    
    
    /**
     * Login
     * 
     * 回傳 Token，如果帳號密碼相符的話。
     * 
     * @param  stdClass $data
     *
     * @return string   Token
     */
    
    function login($data)
    {
        /** 找不到使用者時回傳找不到使用者 */
        if(!$this->exists($data->username))
            return Aira::error('USER_NOT_EXISTED');
        
        /** 取得該使用者的密碼 */
        $password = $this->model->get($data->username, 'password');
        
        if(md5($data->password) !== $password)
            return Aira::error('PASSWORD_INCORRECT'); 
        
        /** 準備要回傳的資料 */
        $result = ['username' => $data->username,
                   'token'    => $this->model->get($data->username, 'token'),
                   'id'       => $this->model->get($data->username, 'id')];
        
        /** 取得該使用者的 Token */
        return Koru::build($result);
    }
    
    
    
    
    /**
     * Get All
     * 
     * 取得指定使用者的所有資料。
     * 
     * @param string $username   使用者帳號。
     * 
     * @return bool|array
     */
    
    function getAll($username)
    {
        /** 找不到使用者時回傳找不到使用者 */
        if(!$this->exists($username))
            return Aira::error('USER_NOT_EXISTED');
            
        return $this->model->getAll($username);
    }
    
    
    
    
    /**
     * Exists
     * 
     * 帳號是否存在。
     * 
     * @param  string $username   帳號名稱。
     * 
     * @return bool
     */
    
    function exists($username)
    {
        return $this->model->exists($username);
    }
}
?>