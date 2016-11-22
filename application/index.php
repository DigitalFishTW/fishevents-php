<?php
include 'bootstrap.php';

/**
 * 建立使用者
 * 
 */

$Davai->put('/application/auth', function()
{
    /** 載入 User 控制器 */
    include __DIR__ . '/controller/user.c.php';
    /** 建立控制器 */
    $User = new User();
    /** 透過 Koru 從 php://input 中建立資料，由 PUT 提供 */
    $data = Koru::buildInput();
    /** 呼叫控制器建立使用者 */
    $result = $User->create($data);
    /** 透過艾拉回傳 USER_CREATED（帶有狀態 200 OK），且回傳 user_id, username, token 三個值 */
    Aira::success('USER_CREATED', ['user_id'  => $result->userId,
                                   'username' => $result->username,
                                   'token'    => $result->token]);
});




/**
 * 登入
 */

$Davai->get('/application/auth/[a:username]/[a:password]', function($username, $password)
{
    include __DIR__ . '/controller/user.c.php';
    
    $User = new User();
    $data = Koru::build(['username' => $username,
                         'password' => $password]);
    
    $result = $User->login($data);

    Aira::endOrSuccess('USER_LOGGED_IN', ['user_id'  => $result->id,
                                          'username' => $result->username,
                                          'token'    => $result->token]);
});


/**
 * 取得個所有
 */

$Davai->get('/application/profile/[a:username]', function($username)
{
    include __DIR__ . '/controller/user.c.php';
    
    $User = new User();
    $data = Koru::build(['username' => $username]);
    
    $result = $User->getAll($data->username);
    
    Aira::endOrSuccess('USER_FOUND', $result);
});


/**
 * 
 */
 
$Davai->put('/application/profile/[a:username]', function($username)
{
    include __DIR__ . '/controller/user.c.php';
    
    $User = new User();
    $data = Koru::buildInput();
    
    $User->putProfile($data);
    
    Aira::endOrSuccess('PROFILE_EDITED');
});


/**
 * 更換密碼
 */

$Davai->patch('/application/auth/[a:username]/[a:password]', function($username, $password)
{
    include __DIR__ . '/controller/user.c.php';
    
    $User = new User();
    $data = Koru::build(['username' => $username,
                         'password' => $password]);
    
    $token = $User->changePassword($data);
    
    Aira::endOrSuccess('PASSWORD_CHANGED');
});


?>