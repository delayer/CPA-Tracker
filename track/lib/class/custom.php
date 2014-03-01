<?php


class custom {
    
    
    
    function __construct() {
        
    }
    
    
    function process_conversion($data) {
        if (isset($data['get']['t'])) {
            $this->proceed_old($data['get']);
            return;
        }
        
        
    }
    
    
    function proceed_old($data) {
        $lead = '';
        $sale = '';
        if (isset($data['s'])) {
            $r = mysql_query('SELECT `id` FROM `tbl_clicks` WHERE `subid` = "'.$data['s'].'"');
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                switch ($data['t']) {
                    case 'lead':
                        $lead = ',`is_lead` = 1';
                        break;
                    case 'sale':
                        $sale = ', `is_sale` = 1';
                        break;
                }
                if (($sale != '' || $lead != '') && isset($d['a'])) {
                    mysql_query('UPDATE `tbl_clicks` SET `conversion_price_main` = '.$data['a'].' '.$lead.$sale.' WHERE `id` = '.$f['id']); 
                }
            }
            $r = mysql_query('SELECT `id` FROM `tbl_conversions` WHERE `subid` = "'.$data['s'].'"');
            if (mysql_num_rows($r) > 0) {
                $f = mysql_fetch_assoc($r);
                
                if (isset($data['a'])) {
                    mysql_query('UPDATE `tbl_conversions` SET `profit` = '.$data['a'].' WHERE `id` = '.$f['id']); 
                }
            }
            else {
                mysql_query('INSERT INTO `tbl_conversions` (`network`, `profit`, `subaccount`, `status`, `txt_param20`) '
                        . 'VALUES ("custom", "'.$data['a'].'", "'.$data['s'].'", 1, "'.$data['c'].'")');
            }
        }
    }
    
    
}




