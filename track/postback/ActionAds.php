<?php


class ActionAds {
    
    
    public $net = 'ActionAds';
    
    private $common;
    
    private $params = array(
        'profit' => 'payout',
        'subid' => 'aff_sub',
        'date_add' => 'datetime',
        'txt_param1' => 'ip',
        'txt_param4' => 'offer_name',
        'txt_param7' => 'source',
        'txt_param14' => 'affiliate_name',
        'txt_param15' => 'file_name',
        'txt_param16' => 'aff_sub2',
        'txt_param17' => 'aff_sub3',
        'txt_param18' => 'aff_sub4',
        'txt_param19' => 'aff_sub5',
        'txt_param20' => 'currency',
        'int_param1' => 'goal_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'transaction_id',
        'int_param7' => 'offer_url_id',
        'int_param10' => 'offer_file_id',
        'int_param11' => 'device_id',
        'int_param12' => 'affiliate_id',
        'int_param13' => 'affiliate_ref',
        'int_param14' => 'offer_ref',
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
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера ActionAds.'
        );
        
        return array(
            0 => $return
        );
    }
    
    
    function proceed_conversion($data_all) {
        $data = $data_all['get'];
        $data['network'] = $this->net;
        $data['status'] = 1;
        unset($data['net']);
        
        
        $this->common->process_conversion($data);
    }
    
    
    
}




