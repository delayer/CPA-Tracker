<?php

// Если не передан API ключ, то пропускаем такое
//if (!isset($_GET['apikey']))
//    exit;

$data['get']    = $_GET;
$data['post']   = $_POST;

if (!isset($data['get']['date_add'])) {
    $data['get']['date_add'] = date('Y-m-d H:i:s');
}

$s_data = serialize($data)."\n";
if (strlen ($s_data)>0)
{
        file_put_contents(dirname (__FILE__).'/cache/postback/.postback_'.date('Y-m-d-H-i'), $s_data, FILE_APPEND | LOCK_EX);		
}

        