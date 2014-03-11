<?php

define('_ROOT_PATH', dirname(__FILE__));

set_time_limit(0);

$settings_file = dirname(__FILE__) . '/cache/settings.php';
$str = file_get_contents($settings_file);
$str = str_replace('<? exit(); ?>', '', $str);
$arr_settings = unserialize($str);

$_DB_LOGIN = $arr_settings['login'];
$_DB_PASSWORD = $arr_settings['password'];
$_DB_NAME = $arr_settings['dbname'];
$_DB_HOST = $arr_settings['dbserver'];

include dirname(__FILE__) . "/connect.php";
include dirname(__FILE__) . "/lib/class/common.php";
include dirname(__FILE__) . "/lib/class/custom.php";
include dirname(__FILE__) . "/../track-show/functions_general.php";


function net_loader($class) {
    include_once dirname(__FILE__).'/postback/'.$class.'.php';
}

spl_autoload_register('net_loader');


$arr_files = array();
if ($handle = opendir(dirname(__FILE__) . '/cache/postback')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && $entry != ".empty") {
            if (
            // Check if file starts with dot,  
                    (strpos($entry, '.') === 0) &&
                    // is not processing now
                    (strpos($entry, '+') === false) &&
                    // and was not processed before
                    (strpos($entry, '*') === false)
            ) {
                // Also check that there were at least 2 minutes from creation date
                if ($entry != '.postback_' . date('Y-m-d-H-i', strtotime('-1 minutes')) &&
                        $entry != '.postback_' . date('Y-m-d-H-i')
                ) {
                    $arr_files[] = $entry;
                }
            }
        }
    }
    closedir($handle);
}
//print_r($arr_files);
if (count($arr_files) == 0) {
    exit();
}

//Если есть что обрабатывать инициализируем класс собственных правил (custom)
$custom = new custom();

foreach ($arr_files as $cur_file) {
    $file_name = dirname(__FILE__) . "/cache/postback/{$cur_file}+";
    $file_name = dirname(__FILE__) . "/cache/postback/{$cur_file}";
    rename(dirname(__FILE__) . "/cache/postback/$cur_file", $file_name);
    $conversions = file($file_name);
    foreach ($conversions as $conv) {
        $data = unserialize($conv);
        if (!isset($data['get']['net']) || $data['get']['net'] == 'custom') {
            $custom->process_conversion($data);
        }
        elseif ($data['get']['net'] == 'pixel') {
            $custom->process_pixel($data);
        }
        else {
            $net = new $data['get']['net']();
            $net->process_conversion($data);
        }
    }
//    exit;
    rename($file_name, dirname(__FILE__) . "/cache/postback/{$cur_file}*");
}

exit();
?>