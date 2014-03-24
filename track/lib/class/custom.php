<?php


class custom {
    
    public $params = array(
        'profit'        => 'profit',
        'subid'         => 'subid',
        'status'        => 'status',
        'date_add'      => 'date_add',
        'txt_param1'    => 'txt_param1',
        'txt_param2'    => 'txt_param2',
        'txt_param4'    => 'txt_param4',
        'txt_param7'    => 'txt_param7',
        'int_param1'    => 'int_param1',
        'int_param2'    => 'int_param2',
        'int_param3'    => 'int_param3'
        
    );
            
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function process_conversion($data) {
        if (isset($data['get']['t'])) {
            $this->proceed_old($data['get']);
            return;
        }
        
        if (!isset($data['get']['date_add']) || $data['get']['date_add'] == '') {
            $data['get']['date_add'] = date('Y-m-d H:i:s');
        }
        
        if (is_int($data['get']['date_add'])) {
            $data['get']['date_add'] = date('Y-m-d H:i:s', $data['get']['date_add']);
        }
        
        unset($data['get']['net']);
        
        $this->common->proceed_conversion($data['get']);
        
    }
    
    
    function proceed_old($data) {
        $lead = '';
        $sale = '';
        if (isset($data['s'])) {
            $r = mysql_query('SELECT `id` FROM `tbl_clicks` WHERE `subid` = "'.$data['s'].'"');
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                switch ($data['t']) {
                    case 'lead':
                        $lead = ',`is_lead` = 1';
                        break;
                    case 'sale':
                        $sale = ', `is_sale` = 1';
                        break;
                }
                if (($sale != '' || $lead != '') && isset($d['a'])) {
                    mysql_query('UPDATE `tbl_clicks` SET `conversion_price_main` = '.$data['a'].' '.$lead.$sale.' WHERE `id` = '.$f['id']); 
                }
            }
            $r = mysql_query('SELECT `id` FROM `tbl_conversions` WHERE `subid` = "'.$data['s'].'"');
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                
                if (isset($data['a'])) {
                    mysql_query('UPDATE `tbl_conversions` SET `profit` = '.$data['a'].' WHERE `id` = '.$f['id']); 
                }
            }
            else {
                mysql_query('INSERT INTO `tbl_conversions` (`network`, `profit`, `subaccount`, `status`, `txt_param20`) '
                        . 'VALUES ("custom", "'.$data['a'].'", "'.$data['s'].'", 1, "'.$data['c'].'")');
            }
        }
    }
    
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/postback.php?net=custom';
        
        $code = $this->common->get_code();
        $url .= '&apikey='.$code;
        
        
        return $url;
    }
    
    function get_pixel_link() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/pixel.php';
        
        $code = $this->common->get_pixelcode();
        $url .= '?apikey='.$code;
        
        
        return $url;
    }
    
    
    
    function process_pixel($data_all) {
        $data = $data_all['get'];
        
        unset($data['net']);
        
        if (!isset($data['subid']))
            $data['subid'] = date("YmdHis").'x'.sprintf ("%05d",rand(0,99999));
        
        if (!isset($data['date_add']))
            $data['date_add'] = date('Y-m-d H:i:s');
        
        $data['network'] = 'pixel';
                
        $this->common->process_conversion($data);
    }
    
    
}
