<?php



class AD1 {
    
    public $net = 'AD1';
    
    private $common;
    
    private $params = array(
        'subid' => 'subid',
        'profit' => 'summ_approved',
        'date_add' => 'postback_date',
        'txt_status' => 'status',
        'txt_param1' => 'uip',
        'txt_param2' => 'uagent',
        'txt_param3' => 'goal_title',
        'txt_param4' => 'offer_name',
        'float_param1' => 'summ_total',
        'int_param1' => 'goal_id',
        'int_param2' => 'offer_id',
        'int_param3' => 'order_id',
        'int_param4' => 'click_time',
        'int_param5' => 'lead_time',
        'int_param6' => 'postback_time',
        'int_param7' => 'rid',
        'date_param1' => 'click_date',
        'date_param2' => 'lead_date'
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
        $return = array(
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках Вашего потока в сети AD1.'
        );
        
        return array(
            0 => $return
        );
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
            case 'waiting':
                $data['txt_status'] = 'Waiting';
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





