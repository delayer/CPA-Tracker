<?php


class Biznip {
    
    
    public $net = 'Biznip';
    
    private $common;
    
    private $params = array(
        'profit' => 'payout',
        'subid' => 'aff_sub',
        'txt_status' => 'status',
        'txt_param5' => 'click_id',
        'txt_param16' => 'aff_sub2',
        'txt_param17' => 'aff_sub3',
        'txt_param18' => 'aff_sub4',
        'txt_param19' => 'aff_sub5',
        'int_param1' => 'goal_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'conversion_id',
    );
    
    private $reg_url = 'http://www.cpatracker.ru/networks/biznip';
    
    private $net_text = 'Лучшая в рунете партнерская программа по инфотоварам. Собственные продукты высочайшего качества по работе в интернете, похудению, построению отношений. Привлеченным клиентам постоянно продолжают продавать услуги и товары с помощью почтовых рассылок, партнеры получают комиссию по повторным продажам, что позволяет стабильно зарабатывать даже после остановки трафика.';
    
    
    
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
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках Biznip.'
        );
        
        return array(
            0 => $return,
            'reg_url' => $this->reg_url,
            'net_text' => $this->net_text
        );
    }
    
    
    function proceed_conversion($data_all) {
        $this->common->log($this->net, $data_all['post'], $data_all['get']);
        $data = $data_all['get'];
        $data['network'] = $this->net;
        
        unset($data['net']);
        
        $data['date_add'] = date('Y-m-d H:i:s');
        
        switch ($data['txt_status']) {
            case 'pendingd':
                $data['status'] = 3;
                break;
            case 'approved':
                $data['status'] = 1;
                break;
            case 'rejected':
                $data['status'] = 2;
                break;
        }
        
        
        $this->common->process_conversion($data);
    }
    
    
    
}




