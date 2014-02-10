<?php



class ActionPay {
    
    
    public $net = 'ActionPay';
    
    private $common;
    
    private $params = array(
        'subid' => 'subaccount',
        'profit' => 'payment',
        'int_param1' => 'aim',
        'int_param2' => 'offer',
        'int_param3' => 'apid',
        'int_param5' => 'time',
        'int_param7' => 'landing',
        'int_param8' => 'source',
        'txt_param9' => 'uniqueid'
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
        
        $return = array();
        
        array_push($return, array(
            'id' => 0,
            'description' => 'Вставьте эту ссылку в поле "Постбэк - Создание"',
            'url' => $url.'&status=created'
        ));
        array_push($return, array(
            'id' => 1,
            'description' => 'Вставьте эту ссылку в поле "Постбэк - Принятие"',
            'url' => $url.'&status=approved'
        ));
        array_push($return, array(
            'id' => 2,
            'description' => 'Вставьте эту ссылку в поле "Постбэк - Отклонение"',
            'url' => $url.'&status=declined'
        ));
        
        
        return $return;
    }
    
    
    
    function process_conversion($data = array()) {
        $params = '`network`, ';
        $vals  = '"'.$this->net.'", ';
        unset($data['net']);
        $cnt  = count($data);
        $i   = 0;
        
        switch ($data['status']) {
            case 'approved':
                $data['txt_status'] = 'Approved';
                $data['status'] = 1;
                break;
            case 'declined':
                $data['txt_status'] = 'Declined';
                $data['status'] = 2;
                break;
            case 'created':
                $data['txt_status'] = 'Created';
                $data['status'] = 3;
                break;
            default:
                $data['txt_status'] = 'Unknown';
                $data['status'] = 0;
                break;
        }
        
        $this->common->process_conversion($data);
        
    }
    
    
}




