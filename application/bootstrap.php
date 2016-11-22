<?php
/** 允許全域標頭 */
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, PATCH, OPTIONS, PUT, DELETE'); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/library/Aira/src/aira.php';
include __DIR__ . '/library/Davai/src/davai.php';
include __DIR__ . '/library/Koru/src/koru.php';
include __DIR__ . '/library/Anything/src/anything.php';
include __DIR__ . '/library/PHP-MySQLi-Database-Class/MysqliDb.php';
include __DIR__ . '/configs.php';

/** 建立資料庫類別 */
$DB            = new MysqliDb('localhost', 'root', '', 'fish_events', 3306);
$GLOBALS['DB'] = $DB;

/** 建立路由 */
$Davai = new Davai();
?>