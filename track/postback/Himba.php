<?php


class Himba {
    
    
    public $net = 'Himba';
    
    private $common;
    
    private $params = array(
        'profit' => 'amount',
        'subid' => 'sub_id',
        'status' => 'status',
        'txt_param7' => 'source',
        'txt_param16' => 'sub_id2',
        'int_param1' => 'goal_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'adv_sub',
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
            $url .= '&'.$name.'={'.$value.'}';
        }
        
        $code = $this->common->get_code();
        $url .= '&apikey='.$code;
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера Himba.'
        );
        
        return array(
            0 => $return
        );
    }
    
    
    function proceed_conversion($data_all) {
        $data = $data_all['get'];
        $data['network'] = $this->net;
        unset($data['net']);
        $data['date_add'] = date('Y-m-d H:i:s');
        
        $this->common->process_conversion($data);
    }
    
    
    
}




