<?php

class CityAds {
    public $net = 'CityAds';
    
    private $common;
    
    private $params = array(
        'subid' => 'subaccount',
        'profit' => 'payout',
        'date_add' => 'conversion_date',
        'txt_param1' => 'ip',
        'txt_param2' => 'ua',
        'txt_param3' => 'target_name',
        'txt_param4' => 'offer_name',
        'txt_param5' => 'click_id',
        'txt_param6' => 'wp_name',
        'txt_param7' => 'site',
        'txt_param8' => 'action_type',
        'txt_param9' => 'country',
        'txt_param10' => 'city',
        'txt_param11' => 'user_browser',
        'txt_param12' => 'user_os',
        'txt_param13' => 'user_device',
        'txt_param20' => 'payout_currency',
        'int_param1' => 'target_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'cpl_id',
        'int_param4' => 'click_time',
        'int_param5' => 'event_time',
        'int_param6' => 'conversion_time',
        'int_param7' => 'wp_id',
        'int_param9' => 'payout_id',
    );
    
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/postback.php?net='.$this->net;

        $code = $this->common->get_code();
        $url .= '&apikey='.$code;
        
        $return = array();
        
        array_push($return, array(
            'id' => 0,
            'description' => '1. Вставьте эту ссылку в поле <b>Postback URL</b> в CityAds.<br>'
            . '2. Выберите Тип запроса <b>GET</b><br>'
            . '3. Поставьте галочки напротив ВСЕХ переменных',
            'url' => $url.'&status=created'
        ));

        return $return;
    }
    
    
    
    function process_conversion($data_all = array()) {
        $this->common->log($this->net, $data_all['post'], $data_all['get']);
        $input_data = $data_all['post'];
        $output_data = array();
        foreach ($input_data as $name => $value) {
            if ($key = array_search($name, $this->params)) {
                $output_data[$key] = $value;
            }
        }
        
        $output_data['status'] = 1;
        $this->common->process_conversion($output_data);
    }
    
}
