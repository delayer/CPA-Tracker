<?php



class common {
    
    
    private $params = array();
    
    
    function __construct($params = array()) {
       $this->params = $params;
    }
    
    
    function set_params($params) {
        if (is_array($params)) {
            $this->params = $params;
        }
    }
    
    
    function process_conversion($data) {
        $cnt  = count($this->params);
        $i   = 0;
        $is_lead = (isset($data['is_lead']))?1:0;
        $is_sale = (isset($data['is_sale']))?1:0;
        unset($data['is_lead']);
        unset($data['is_dale']);
        
        if (isset($data['subid']) && $data['subid'] != '') {
            //Проверяем есть ли клик с этим SibID
            $r = mysql_query('SELECT `id` FROM `tbl_clicks` WHERE `subid` = "'.$data['subid'].'"') or die(mysql_error());
            
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                mysql_query('UPDATE `tbl_clicks` SET `is_sale` = '.$is_sale.', `is_lead` = '.$is_lead.', `conversion_price_main` = '.$data['profit'].' WHERE `id` = '.$f['id']) or die(mysql_error());
            }


            // Проверяем, есть ли уже конверсия с таким SubID
            $r = mysql_query('SELECT * FROM `tbl_conversions` WHERE `subid` = "'.$data['subid'].'" LIMIT 1') or die(mysql_error());
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                
                $update = '';
                foreach ($data as $name => $value) {
                    if (array_key_exists($name, $this->params)) {
                        $update .= ', `'.$name.'` = "'.$value.'"';
                        unset($data[$name]);
                    }
                }
                
                if (isset($data['date_add'])) {
                    $update .= ', `date_add` = "'.$data['date_add'].'"';
                    unset($data['date_add']);
                }
                
                if (isset($data['txt_status'])) {
                    $update .= ', `txt_status` = "'.$data['txt_status'].'"';
                    unset($data['txt_status']);
                }
                
                if (isset($data['status'])) {
                    $update .= ', `status` = "'.$data['status'].'"';
                    unset($data['txt_status']);
                }

                mysql_query('UPDATE `tbl_conversions` SET `network` = "'.$data['network'].'"'.$update.' WHERE `id` = '.$f['id']) or die(mysql_error());
                unset($data['network']);
                mysql_query('DELETE FROM `tbl_postback_params` WHERE `conv_id` = '.$f['id']) or die(mysql_error());
                
                foreach ($data as $name => $value) {
                    mysql_query('INSERT INTO `tbl_postback_params` (`conv_id`, `name`, `value`)'
                            . 'VALUES ('.$f['id'].', "'.$name.'", "'.$value.'")') or die(mysql_error());
                }
                
                return;
            }
            
        }
        
        
        
        foreach ($data as $name => $value) {
            if (array_key_exists($name, $this->params)) {
                $params .= ',`'.$name.'`';
                $vals .= ',"'.$value.'"';
                unset($data[$name]);
            }
        }
        $add_names = '';
        $add_vals = '';
        
        if (isset($data['date_add'])) {
            $add_names .= ', `date_add`';
            $add_vals .= ' "'.$data['date_add'].'"';
            unset($data['date_add']);
        }

        if (isset($data['txt_status'])) {
            $add_names .= ', `txt_status`';
            $add_vals .= ' "'.$data['txt_status'].'"';
            unset($data['txt_status']);
        }

        if (isset($data['status'])) {
            $add_names .= ', `status`';
            $add_vals .= ' "'.$data['status'].'"';
            unset($data['status']);
        }
        
        mysql_query('INSERT INTO `tbl_conversions` (`network`  '.$params.') VALUES ("'.$data['network'].'" '.$vals.')') or die(mysql_error());
        $conv_id = mysql_insert_id();
        unset($data['network']);
        foreach ($data as $name => $value) {
            if (strpos($name, 'bsave_') > 0) {
                $name = str_replace('pbsave_', '', $name);
                mysql_query('INSERT INTO `tbl_postback_params` (`conv_id`, `name`, `value`)'
                        . 'VALUES ('.$conv_id.', "'.$name.'", "'.$value.'")') or die(mysql_error());
            }
        }
    }
    
    
    
    function get_code() {
        if (is_file(_ROOT_PATH.'/cache/.postback.key')) {
            $key = file_get_contents(_ROOT_PATH.'/cache/.postback.key');
            return $key;
        }
        else {
            $key = substr(md5(__FILE__), 3, 10);
            file_put_contents(_ROOT_PATH.'/cache/.postback.key', $key);
            return $key;
        }
    }
    
    function get_pixelcode() {
        if (is_file(_ROOT_PATH.'/cache/.pixel.key')) {
            $key = file_get_contents(_ROOT_PATH.'/cache/.pixel.key');
            return $key;
        }
        else {
            $key = substr(md5(__FILE__.'TraCKKERPIxxel'), 3, 10);
            file_put_contents(_ROOT_PATH.'/cache/.pixel.key', $key);
            return $key;
        }
    }
    
    
    function log($net, $post, $get) {
        if (!isset($get['apikey']) || ($this->get_code() != $get['apikey'])) {
            return;
        }
        
        if (!is_dir(_ROOT_PATH.'/cache/pblogs/')) {
            mkdir(_ROOT_PATH.'/cache/pblogs');
        }
        
        $log = fopen(_ROOT_PATH.'/cache/pblogs/.'.$net.date('Y-m-d').'.txt', 'a+');
        
        if ($log) {
            fwrite($log, '['.date('Y-m-d H:i:s').'] [POST] '. var_export($post));
            fwrite($log, '['.date('Y-m-d H:i:s').'] [GET] '.  var_export($get));
            fclose($log);
        }        
    }
    
    
    
}




