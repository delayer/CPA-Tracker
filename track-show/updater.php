<?php

set_time_limit(0);
error_reporting(0);
ini_set('display_errors', 0);

$include_flag = true;

include "functions_general.php";

disable_magic_quotes();

// Check file with db and server settings
$settings = check_settings();


if ($settings[0]) {
    mysql_connect($settings[1]['dbserver'], $settings[1]['login'], $settings[1]['password']) or die('Ошибка подключения к БД');
    mysql_select_db($settings[1]['dbname']) or die('Неверная база данных');
    
    
    $r = mysql_query('SELECT * FROM `tbl_offers`');
    
    while ($f = mysql_fetch_assoc($r)) {
        echo preg_replace('/\%([a-z0-9\_\-]+)\%/i', "[\$1]", $f['offer_tracking_url']).'<br>';
    }
}




