<?php



class common {
    
    
    private $params = array();
    
    
    function __construct($params) {
       $this->params = $params;
    }
    
    
    function process_conversion($data) {
        $is_lead = (isset($data['is_lead']))?1:0;
        $is_sale = (isset($data['is_sale']))?1:0;
        unset($data['is_lead']);
        unset($data['is_dale']);
        
        if (isset($data['subid'])) {
            //Проверяем есть ли клик с этим SibID
            $r = mysql_query('SELECT `id` FROM `tbl_clicks` WHERE `subid` = "'.$data['subid'].'"');
            
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                mysql_query('UPDATE `tbl_clicks` SET `is_sale` = '.$is_sale.', `is_lead` = '.$is_lead.', `conversion_price_main` = '.$data['profit'].' WHERE `id` = '.$f['id']);
            }


            // Проверяем, есть ли уже конверсия с таким SubID из этой же сетки
            $r = mysql_query('SELECT * FROM `tbl_conversions` WHERE `subid` = "'.$data['subid'].'" AND `network` = "'.$this->net.'" LIMIT 1') or die(mysql_error());
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                $update = '';
                foreach ($data as $name => $value) {
                    if (array_key_exists($name, $this->params) || $name == 'status' || $name == 'txt_status') {
                        $update .= '`'.$name.'` = "'.$value.'"';
                        if ($i < $cnt) {
                            $update .= ', ';
                        }
                    }
                    $i++;
                }
//                echo 'UPDATE `tbl_conversions` SET '.$update.' WHERE `id` = '.$f['id'];
                mysql_query('UPDATE `tbl_conversions` SET '.$update.' WHERE `id` = '.$f['id']) or die(mysql_error());
                return;
            }
            
        }
        
        foreach ($data as $name => $value) {
            if (array_key_exists($name, $this->params) || $name == 'status' || $name == 'txt_status') {
                $params .= '`'.$name.'`';
                $vals .= '"'.$value.'"';
                if ($i < $cnt) {
                    $params .= ', ';
                    $vals .= ', ';
                }
            }
            $i++;
        }
        $params .= ', `date_add`';
        $vals .= ', "'.date('Y-m-d H:i:s').'"';
        mysql_query('INSERT INTO `tbl_conversions` ('.$params.') VALUES ('.$vals.')') or die(mysql_error());
    }
    
    
}




