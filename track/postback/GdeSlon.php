<?php


class GdeSlon {
    
    
    public $net = 'GdeSlon';
    
    private $common;
    
    private $params = array(
        'profit' => 'profit',
        'subid' => 'sub_id',
        'txt_param1' => 'action_ip',
        'txt_param2' => 'user_agent',
        'txt_param5' => 'click_id',
        'txt_param7' => 'user_referrer',
        'float_param1' => 'order_sum',
        'int_param2' => 'merchant_id',
        'int_param3' => 'order_id',
        'int_param4' => 'click_time',
        'int_param6' => 'action_time',
    );
    
    private $reg_url = 'http://www.gdeslon.ru/users/new';
    
    private $net_text = 'Устали от серости на графиках? С нами они обретут краски! Наши рекламодатели получают реальные продажи, а вебмастера - хорошее вознаграждение.';
    
    
    
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
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках GdeSlon и выберите метод запроса GET'
        );
        
        return array(
            0 => $return,
            'reg_url' => $this->reg_url,
            'net_text' => $this->net_text
        );
    }
    
    
    function proceed_conversion($data_all) {
        $this->common->log($this->net, $data_all['post'], $data_all['get']);
        $input_data = $data_all['get'];
        $output_data = array();
        foreach ($input_data as $name => $value) {
            if ($key = array_search($name, $this->params)) {
                $output_data[$key] = $value;
            }
        }
        $output_data['network'] = $this->net;
        $output_data['status'] = 1;
        $output_data['date_add'] = date('Y-m-d H:i:s', $output_data['action_time']);
        $this->common->process_conversion($output_data);
    }
    
    
    
}




