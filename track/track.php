<?php
	ob_start();

	$settings_file=dirname (__FILE__).'/cache/settings.php';
	$str=file_get_contents($settings_file);
	$str=str_replace('<? exit(); ?>', '', $str);
	$arr_settings=unserialize($str);

	$_DB_LOGIN=$arr_settings['login'];
	$_DB_PASSWORD=$arr_settings['password'];
	$_DB_NAME=$arr_settings['dbname'];
	$_DB_HOST=$arr_settings['dbserver'];
	$_SERVER_TYPE=$arr_settings['server_type'];
	if ($_SERVER_TYPE==''){exit();}

	if (!function_exists('remove_tab'))
	{
		function remove_tab($str){
			return str_replace ("\t", ' ', $str);
		}
	}
         function getProvider($ip = NULL){ 
                if(empty($ip)) return ''; 
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, 'http://www.ipaddresslocation.org/ip-address-locator.php'); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_POST, true); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('ip' => $ip)); 
                $data = curl_exec($ch); 
                curl_close($ch);     
                preg_match_all('/<i>([a-z\s]+)\:<\/i>\s+<b>(.*)<\/b>/im', $data, $matches, PREG_SET_ORDER); 
                if(count($matches) == 0) return false;  
                foreach($matches as $info) 
                { 
                 if(isset($info[2]) && $info[1]=='ISP Provider') 
                   { 
                      return $info[2]; 
                   } 
                } 
                return '';
           } 
	if (!function_exists('get_geodata'))
	{
		function get_geodata($ip)
		{
			require_once (dirname (__FILE__)."/lib/maxmind/geoip.inc.php");
			require_once (dirname (__FILE__)."/lib/maxmind/geoipcity.inc.php");
			require_once (dirname (__FILE__)."/lib/maxmind/geoipregionvars.php");
			$gi = geoip_open(dirname (__FILE__)."/lib/maxmind/MaxmindCity.dat", GEOIP_STANDARD);
			$record = geoip_record_by_addr($gi, $ip); 
			geoip_close($gi);
			return array ('country'=>$record->country_code, 'state'=>$GEOIP_REGION_NAME[$record->country_code][$record->region], 'city'=>$record->city, 'region'=>$record->region);
		}
	}
               
	if (!function_exists('get_rules'))
	{
		function get_rules($rule_name)
		{
			global $_DB_LOGIN, $_DB_PASSWORD, $_DB_NAME, $_DB_HOST;
			$rule_hash=md5 ($rule_name);

			$cache_path=dirname (__FILE__).'/cache';
			$rules_path="{$cache_path}/rules";
			$rule_path="{$rules_path}/.{$rule_hash}";

			if (is_file($rule_path))
			{
				$str_rules=file_get_contents($rule_path);
				$arr_rules=unserialize($str_rules);
				return $arr_rules;
			}
			else
			{
				require_once (dirname(__FILE__)."/connect.php"); 
				$sql="select tbl_rules.id as rule_id, tbl_rules_items.id, tbl_rules_items.parent_id, tbl_rules_items.type, tbl_rules_items.value from tbl_rules left join tbl_rules_items on tbl_rules_items.rule_id=tbl_rules.id where tbl_rules.link_name='".mysql_real_escape_string($rule_name)."' and tbl_rules.status=0 and tbl_rules_items.status=0 order by tbl_rules_items.parent_id, tbl_rules_items.id";
				$result=mysql_query($sql);
				
				$arr_items=array();
				$rule_id=0;
				while ($row=mysql_fetch_assoc($result))
				{
					$rule_id=$row['rule_id'];
					$arr_items[$row['id']]=$row;
				}
				
				if (count($arr_items)==0)
				{
					return array();
				}

				$arr_rules=array();
				foreach ($arr_items as $row)
				{
                                    if ($row['parent_id']>0)
                                    {
                                     $arr_rules[$arr_items[$row['parent_id']]['type']][$arr_items[$row['parent_id']]['value']]=array('rule_id'=>$rule_id, 'out_id'=>$row['value']);
                                    }
				}
				$str_rules=serialize($arr_rules);

				if (!is_dir($rules_path))
				{
					mkdir ($rules_path);
					chmod ($rules_path, 0777);
				}

				if (is_writable($rules_path))
				{
					file_put_contents($rule_path, $str_rules);
					chmod ($rule_path, 0777);
				}
				return $arr_rules;

			}
		}
	}

	if (!function_exists('get_out_link'))
	{
		function get_out_link($id)
		{
			global $_DB_LOGIN, $_DB_PASSWORD, $_DB_NAME, $_DB_HOST;
			$link='';
			$id=intval($id);
			if ($id<=0)
			{
				return '';
			}

			$cache_path=dirname (__FILE__).'/cache';
			$outs_path="{$cache_path}/outs";
			$out_path="{$outs_path}/.{$id}";

			if (is_file($out_path))
			{
				$link=file_get_contents($out_path);
			}
			else
			{
				require_once (dirname(__FILE__)."/connect.php");
				$sql="select offer_tracking_url from tbl_offers where id='".mysql_real_escape_string($id)."'";
				$result=mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				$link=$row['offer_tracking_url'];

				if ($link=='')
				{
					return '';
				}

				if (!is_dir($outs_path))
				{
					mkdir ($outs_path);
					chmod ($outs_path, 0777);
				}

				if (is_writable($outs_path))
				{
					file_put_contents($out_path, $link);
					chmod ($out_path, 0777);
				}
			}

			return $link;
		}
	}

	// Remove trailing slash
	$track_request=rtrim($_REQUEST['track_request'], '/');
	$track_request=explode ('/', $track_request);

	$str='';

	// Date
	$str.=date("Y-m-d H:i:s")."\t";

	switch ($_SERVER_TYPE)
	{
		case 'apache': 
			$ip=$_SERVER['REMOTE_ADDR'];
		break;

		case 'nginx':
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		break;
	}

	// Check if we have several ip addresses
	if (strpos($ip, ',')!==false)
	{
		$arr_ips=explode (',', $ip);
		if (trim($arr_ips[0])!='127.0.0.1')
		{
			$ip=trim($arr_ips[0]);
		}
		else
		{
			$ip=trim($arr_ips[1]);
		}
	}
	
	$str.=remove_tab($ip)."\t";
	
	// Country and city
	$geo_data=get_geodata($ip);
	$cur_country=$geo_data['country'];
	$cur_state=$geo_data['state'];
	$cur_city=$geo_data['city'];
        
	// User language
        $user_lang =  substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                
	// User-agent
	$str.=remove_tab($_SERVER['HTTP_USER_AGENT'])."\t";
	
	// Referer
	$str.=remove_tab($_SERVER['HTTP_REFERER'])."\t";
	
	// Link name
	$link_name=$track_request[0];
	$str.=$link_name."\t";

	// Link source
	$link_source=$track_request[1];	
	$str.=$link_source."\t";

	// Link ads name
	$link_ads_name=$track_request[2];
	$str.=$link_ads_name."\t";

	// Subid
	$subid=date("YmdHis").'x'.sprintf ("%05d",rand(0,99999));
	$str.=$subid."\t";

	// Subaccount
	$str.=$subid."\t";
	
	// Apply rules and get out id for current click
	$arr_rules = get_rules ($link_name); 
	if (count($arr_rules)==0)
	{
		 exit();
	}
	else
	{ 
            
          $user_params = array(); 
          $user_params['ip'] = $ip;
          $user_params['city'] = $cur_city;
          $user_params['region'] = $cur_state;
          $user_params['provider'] = getProvider($ip);
          $user_params['lang'] = $user_lang;
          $user_params['referer'] =  $_SERVER['HTTP_REFERER'];
          $user_params['geo_country'] = $cur_country;
          $rule_id=$arr_rules['geo_country']['default']['rule_id'];
          $out_id=$arr_rules['geo_country']['default']['out_id']; 
          foreach ($arr_rules as $key  => $value) {
            if(isset($value[$user_params[$key]])){
               $rule_id =  $value[$user_params[$key]]['rule_id'];
               $out_id =  $value[$user_params[$key]]['out_id'];
               break;
            }
          } 
	}
	$redirect_link=str_replace('%SUBID%', $subid, get_out_link ($out_id));

	// Add rule id
	$str.=$rule_id."\t";

	// Add out id
	$str.=$out_id."\t";
	
	// Other link params
	// Limit number of params to 5
	$track_request=array_slice($track_request, 3, 5);

	// Extend array to 5 params exactly
	$arr_link_params=array();
	for ($i=0; $i<5; $i++)
	{
		if (isset($track_request[$i]))
		{
			$arr_link_params[]=$track_request[$i];
		}
		else
		{
			$arr_link_params[]='';
		}
	}

	$link_params=implode ("\t", $arr_link_params);

	// Possibly last value, don't add \t to the end
	$str.=$link_params;

	// Additional GET params
	$request_params=$_GET;
	$get_request=array();
	foreach ($request_params as $key=>$value)
	{
		if ($key=='track_request'){continue;}
                if (strtoupper(substr($key, 0, 3)) == 'IN_') {
                    $var = substr($key, 3);
                    $redirect_link = str_ireplace('%'.$var.'%', $value, $redirect_link);
                }
		$get_request[]="{$key}={$value}";
	}
        
        //Cleaning not used %-params
        $redirect_link = preg_replace('/(%[a-z\_0-9]+%)/i', '', $redirect_link);
	
	// Last value, don't add \t
	$request_string=implode ('&', $get_request);
	if (strlen($request_string)>0)
	{
		$str.="\t".$request_string;
	}
		
	$str.="\n";

	// Save click information in file	
	file_put_contents(dirname (__FILE__).'/cache/clicks/'.'.clicks_'.date('Y-m-d-H-i'), $str, FILE_APPEND | LOCK_EX);
	
	// Redirect
	header("Location: ".$redirect_link);

	exit();
?>