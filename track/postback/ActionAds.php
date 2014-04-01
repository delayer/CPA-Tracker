<?php


class ActionAds {
    
    
    public $net = 'ActionAds';
    
    private $common;
    
    private $params = array(
        'profit' => 'payout',
        'subid' => 'aff_sub',
        'date_add' => 'datetime',
        't1' => 'ip',
        't4' => 'offer_name',
        't7' => 'source',
        't14' => 'affiliate_name',
        't15' => 'file_name',
        't16' => 'aff_sub2',
        't17' => 'aff_sub3',
        't18' => 'aff_sub4',
        't19' => 'aff_sub5',
        't20' => 'currency',
        'i1' => 'goal_id',
        'i2' => 'offer_id',
        'i3' => 'transaction_id',
        'i7' => 'offer_url_id',
        'i10' => 'offer_file_id',
        'i11' => 'device_id',
        'i12' => 'affiliate_id',
        'i13' => 'affiliate_ref',
        'i14' => 'offer_ref',
    );
    
    
    private $reg_url = 'http://www.cpatracker.ru/networks/actionads';
    
    private $net_text = 'Дружелюбная партнерская сеть с большим количеством рекламодателей и эксклюзивными офферами. Администрация готова на все ради своих партнёров: сделать выплату раньше, помочь консультацией, проинформировать обо всех изменениях в офферах и ответить на возникшие вопросы. Идеальный выбор для начинающего вебмастера.';
    
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/p.php?n='.$this->net;
        foreach ($this->params as $name => $value) {
            $url .= '&'.$name.'={'.$value.'}';
        }
        
        $code = $this->common->get_code();
        $url .= '&ak='.$code;
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера ActionAds.'
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
        $data['status'] = 1;
        unset($data['net']);
        
        
        $this->common->process_conversion($data);
    }
    
    
    
}




