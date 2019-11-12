<?php

//連接帳號資料表，檢查帳密是否正確
// $db_server = "sql200.web.youp.ga:3306"; //資料庫主機位置
$db_user = 'root'; //資料庫的使用帳號
$db_password = 'admin123'; //資料庫的使用密碼
$db_name = 'newpalace_alert'; //資料庫名稱
//PDO的連接語法
try {
    //$pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_password);
    //測試用
    $pdo = new PDO("mysql:host=192.168.2.19:3306;dbname=$db_name", $db_user, $db_password);
    //設定為utf8編碼，必要設定
    $pdo->query('SET NAMES "utf8"');
    date_default_timezone_set('Asia/Taipei');
} catch (PDOException $e) {
    // 資料庫連結失敗
    echo '資料庫連線錯誤，請和技術人員聯繫';
}
