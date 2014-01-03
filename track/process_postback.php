<?php

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
include dirname(__FILE__) . "/../track-show/functions_general.php";

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

if (count($arr_files) == 0) {
    exit();
}

foreach ($arr_files as $cur_file) {
    $file_name = dirname(__FILE__) . "/cache/postback/{$cur_file}+";
    rename(dirname(__FILE__) . "/cache/postback/$cur_file", $file_name);
    $handle = fopen($file_name, "r");
    while (($buffer = fgets($handle, 4096)) !== false) {
        $arr_postback = array();
        $arr_postback = explode("\t", rtrim($buffer, "\n"));

        $type = trim($arr_postback[0]);
        $amount = trim($arr_postback[1]);
        $currency = trim($arr_postback[2]);
        $subid = trim($arr_postback[3]);

        switch (strtolower($currency)) {
            case 'rub':
                $amount = $amount / 30;
                break;

            default:
                break;
        }
        import_sale_info($type, $amount, $subid);
    }
    fclose($handle);
    rename($file_name, dirname(__FILE__) . "/cache/postback/{$cur_file}*");
}

exit();
?>