<?php



class AD1 {
    
    public $net = 'AD1';
    
    private $profit_index = 'summ_approved';
    
    private $click_time = 'click_time';
    
    private $params = array(
        'subid' => 'subid',
        'profit' => 'summ_approved',
        'date_add' => 'lead_date',
        'conv_status' => 'status',
        'user_ip' => 'uip',
        'param1' => 'offer_name',
        'param2' => 'goal_title',
        'param10' => 'uagent',
        'param11' => 'offer_id',
        'param12' => 'goal_id',
        'param13' => 'order_id',
        'param14' => 'summ_total',
        'param15' => 'rid',
        'param18' => 'lead_time',
        'param19' => 'click_time',
        'param20' => 'postback_time',
        'param_date1' => 'click_date',
        'param_date2' => 'postback_date'
    );
    
    
    function __construct() {
        
    }
    
    
    function get_link() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/postback.php?net=AD1';
        foreach ($this->params as $name => $value) {
            $url .= '&'.$name.'={'.$value.'}';
        }
        return $url;
    }
    
    
    function get_instruction() {
        return 'Скопируйте и введите данную ссылку в настройках Потока в сети AD1. Меню: Инструменты -> Потоки';
    }
    
    
}





