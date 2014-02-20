<?php


class Myragon {
    
    
    public $net = 'Myragon';
    
    private $common;
    
    private $params = array(
        'profit' => 'price',
        'subid' => 'sa',
        'txt_status' => 'event',
        'txt_param3' => 'target_name',
        'txt_param4' => 'offer_name',
        'txt_param20' => 'currency',
        'int_param1' => 'target_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'order_id',
        'int_param6' => 'timestamp',
    );
    
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/postback.php?net='.$this->net;
        foreach ($this->params as $name => $value) {
            $url .= '&'.$name.'=[='.$value.'=]';
        }
        
        $code = $this->common->get_code();
        $url .= '&apikey='.$code;
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера Myragon.'
        );
        
        return array(
            0 => $return
        );
    }
    
    
    function proceed_conversion($data_all) {
        $data = $data_all['get'];
        $data['network'] = $this->net;
        unset($data['net']);
        
        switch ($data['txt_status']) {
            case 'New':
                $data['status'] = 3;
                break;
            case 'Done':
                $data['status'] = 1;
                break;
            case 'Canceled':
                $data['status'] = 2;
                break;
            case 'Wait':
                $data['status'] = 4;
                break;
        }
        
        $data['date_add'] = date('Y-m-d H:i:s', $data['timestamp']);
        
        $this->common->process_conversion($data);
    }
    
    
    
}




