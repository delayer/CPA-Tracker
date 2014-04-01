<?php


class GdeSlon {
    
    
    public $net = 'GdeSlon';
    
    private $common;
    
    private $params = array(
        'profit' => 'profit',
        'subid' => 'sub_id',
        't1' => 'action_ip',
        't2' => 'user_agent',
        't5' => 'click_id',
        't7' => 'user_referrer',
        'f1' => 'order_sum',
        'i2' => 'merchant_id',
        'i3' => 'order_id',
        'i4' => 'click_time',
        'i6' => 'action_time',
    );
    
    private $reg_url = 'http://www.cpatracker.ru/networks/gdeslon';
    
    private $net_text = 'Крупнейшая российская товарная партнерская сеть. Удобные механизмы для создания партнерских магазинов, товарные виджеты для ваших сайтов, купоны и промо-коды. Идеальный выбор для создания собственных сайтов, нацеленных на SEO продвижение или раскрутку в социальных сетях. Привлекайте клиентов и получайте вознаграждение, об остальном позаботится партнерская программа.';
    
    
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/p.php?n='.$this->net;
        
        $code = $this->common->get_code();
        $url .= '&ak='.$code;
        
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




