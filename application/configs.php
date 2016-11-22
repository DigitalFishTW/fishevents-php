<?php
/** 
 * 成功訊息
 */
 
Aira::addSuccess('USER_CREATED'    , '帳號成功註冊了！', 200);
Aira::addSuccess('USER_LOGGED_IN'  , '帳號成功登入了！', 200);
Aira::addSuccess('USER_FOUND'      , ' 找到帳號！', 302);
Aira::addSuccess('PROFILE_EDITED'  , ' 個人資料編輯成功！', 200);
Aira::addSuccess('PASSWORD_CHANGED', ' 密碼成功變換！', 200);




/** 
 * 失敗訊息
 */
 
Aira::add('USER_NOT_EXISTED'  , '找不到該帳號。', 404);
Aira::add('PASSWORD_INCORRECT', '密碼不符。', 403);
?>