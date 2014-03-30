<?php


class UnileadNetwork {
    
    
    public $net = 'UnileadNetwork';
    
    private $common;
    
    private $params = array(
        'profit' => 'payout',
        'subid' => 'aff_sub',
        'date_add' => 'datetime',
        'txt_param1' => 'ip',
        'txt_param4' => 'offer_name',
        'txt_param7' => 'source',
        'txt_param12' => 'device_os',
        'txt_param13' => 'device_brand',
        'txt_param14' => 'affiliate_name',
        'txt_param15' => 'file_name',
        'txt_param16' => 'aff_sub2',
        'txt_param17' => 'aff_sub3',
        'txt_param18' => 'aff_sub4',
        'txt_param19' => 'aff_sub5',
        'txt_param20' => 'currency',
        'txt_param21' => 'device_model',
        'txt_param22' => 'device_os_version',
        'txt_param23' => 'device_id',
        'txt_param24' => 'android_id',
        'txt_param25' => 'mac_address',
        'txt_param26' => 'open_udid',
        'txt_param27' => 'ios_ifa',
        'txt_param28' => 'ios_ifv',
        'txt_param29' => 'unid',
        'txt_param30' => 'mobile_ip',
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
    
    private $reg_url = 'http://www.cpatracker.ru/networks/unilead';
    
    private $net_text = 'Международная сеть с большим количеством офферов для российского трафика. Сеть специализируется на мобильных офферах для iPhone и Android, с оплатой за установку приложений. Среди рекламодателей такие известные бренды как Castle Clash, Kaspersky Internet Security, Drakensang Online, Carnage и Travian. Кроме игр сеть предлагает также мобильные лендинги для кредитных продуктов, заказа такси и товаров Mail.Ru.';
    
    
    
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
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера UnileadNetwork.'
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




