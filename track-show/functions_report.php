<?
	function get_visitors_flow_data($filter='')
	{
		$timezone_shift=get_current_timezone_shift();

		$filter_str='';
		if ($filter!='')
		{
			switch ($filter['filter_by'])
			{
				case 'hour': 
					$filter_str="where source_name='".mysql_real_escape_string($filter['source_name'])."' AND CONVERT_TZ(date_add, '+00:00', '".mysql_real_escape_string($timezone_shift)."') BETWEEN '".mysql_real_escape_string($filter['date'])." ".mysql_real_escape_string($filter['hour']).":00:00' AND '".mysql_real_escape_string($filter['date'])." ".mysql_real_escape_string($filter['hour']).":59:59' ";				
				break;
				
				default:
					$filter_str="where ".mysql_real_escape_string ($filter['filter_by'])."='".$filter['filter_value']."'";
				break;
			}
		}
		
		$sql="select *, date_format(CONVERT_TZ(tbl_clicks.date_add, '+00:00', '".mysql_real_escape_string($timezone_shift)."'), '%d.%m.%Y %H:%i') as dt, timediff(NOW(), tbl_clicks.date_add) as td from tbl_clicks 
		{$filter_str}
		order by date_add desc limit 20";


		$result=mysql_query($sql);
		$arr_data=array();
		while ($row=mysql_fetch_assoc($result))
		{
			$row['td']=get_relative_mysql_time($row['td']);				
			$arr_data[]=$row;
		}

		return $arr_data;
	}
	
	function get_clicks_report_grouped ($main_column, $group_by, $limited_to='', $report_type='daily', $from='', $to='')
	{
		$timezone_shift=get_current_timezone_shift();

		switch ($report_type)
		{
			case 'hourly':
				$time_column_alias='date_add_hour';
				$time_column="HOUR(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."')) as date_add_hour";
				$group_time_column="HOUR(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."'))";
				$order_time_column="date_add_hour";
				if ($from=='')
				{
					if ($to=='')
					{
						$time_filter="1=1";
					}
					else
					{
						$time_filter="CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."') <= '"._str($to)." 23:59:59'";
					}
				}
				else
				{
					if ($to=='')
					{
						$time_filter="CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."') >= '"._str($from)." 00:00:00'";
					}
					else
					{
						$time_filter="CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."') BETWEEN '"._str($from)." 00:00:00' AND '"._str($to)." 23:59:59'";
					}
				}
			break;

			case 'daily':
				$time_column_alias="date_add_day";
				$time_column="DATE(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."')) as date_add_day";
				$group_time_column="DATE(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."'))";
				$order_time_column="date_add_day";

				$time_filter="`date_add_day` >= DATE_SUB( DATE(CONVERT_TZ(NOW(), '+00:00', '"._str($timezone_shift)."')) , INTERVAL 7 DAY)";

				if ($from=='')
				{
					if ($to=='')
					{
						$from=get_current_day('-6 days');
						$to=get_current_day();
					}
					else
					{
						$from=date ('Y-m-d', strtotime('-6 days', strtotime($to)));
					}
				}
				else
				{
					if ($to=='')
					{
						$to=date ('Y-m-d', strtotime('+6 days', strtotime($from)));
					}
					else
					{
						// Will use existing values
					}
				}

				$time_filter="CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."') BETWEEN '"._str($from)." 00:00:00' AND '"._str($to)." 23:59:59'";	
			break;
			case 'monthly':
				$time_column_alias="date_add_day";
				$time_column="DATE(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."')) as date_add_day";
				$group_time_column="DATE(CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."'))";
				$order_time_column="date_add_day";

				$time_filter="`date_add_day` >= DATE_SUB( DATE(CONVERT_TZ(NOW(), '+00:00', '"._str($timezone_shift)."')) , INTERVAL 7 DAY)";

				if ($from=='')
				{
					if ($to=='')
					{
						$from=get_current_day('-6 months');
						$to=get_current_day();
					}
					else
					{
						$from=date ('Y-m-d', strtotime('-6 months', strtotime($to)));
					}
				}
				else
				{
					if ($to=='')
					{
						$to=date ('Y-m-d', strtotime('+6 months', strtotime($from)));
					}
					else
					{
						 $from=date ('Y-m-d',  strtotime('13.'.$from));
                                              $to=date ('Y-m-d', strtotime('13.'.$to));
					}
				}
           $from=date ('Y-m-01',  strtotime($from));
           $to=date ('Y-m-t',  strtotime($to));
				$time_filter="CONVERT_TZ(date_add, '+00:00', '"._str($timezone_shift)."') BETWEEN '"._str($from)." 00:00:00' AND '"._str($to)." 23:59:59'";	
			break;

			default: 
				$time_column_alias="date_add_day";
				$time_column="date_add_day";
				$group_time_column="date_add_day";
				$order_time_column="date_add_day";
				$time_filter="`date_add_day` >= DATE_SUB( CURDATE() , INTERVAL 7 DAY)";
			break;
		}

		if ($limited_to!=''){$limited_to=" and `"._str($main_column)."`='"._str($limited_to)."'";}
	
		if ($main_column==$group_by)
		{
			$sql="SELECT 
					`"._str($main_column)."`, 
					{$time_column}, 
					SUM(`click_price`) as clicks_price, 
					SUM(`conversion_price_main`) as conversions_sum, 
					SUM(`is_parent`) as parent_count, 
					`is_sale`, 
					`is_lead`, 
					COUNT(`id`) AS cnt
				FROM 
					`tbl_clicks`
				WHERE 
					{$time_filter}
					{$limited_to}
				GROUP BY 
					`"._str($main_column)."`, 
					`is_sale`, 
					`is_lead`,
					{$group_time_column}
				ORDER BY 
					`"._str($main_column)."`, 
					{$order_time_column} ASC
					"; 
		}
		else
		{
			switch ($group_by)
			{
				case 'user_platform': 
					$sql="SELECT 
							`"._str($main_column)."`, 
							CONCAT(`user_platform`, ' ', `user_platform_info`) as user_platform, 
							{$time_column}, 
							SUM(`click_price`) as clicks_price, 
							SUM(`conversion_price_main`) as conversions_sum, 
							SUM(`is_parent`) as parent_count, 
							`is_sale`, 
							`is_lead`, 
							COUNT(`id`) AS cnt
						FROM 
							`tbl_clicks`
						WHERE 
							{$time_filter}
							{$limited_to}
						GROUP BY 
							`"._str($main_column)."`, 
							`user_platform`,
							`user_platform_info`,
							`is_sale`, 
							`is_lead`,
							{$group_time_column}
						ORDER BY 
							`"._str($main_column)."`, 
							`"._str($group_by)."`,
							{$order_time_column} ASC
							";				
				break;

				case 'referer':
					$sql="SELECT 
						`"._str($main_column)."`, 
						LEFT(referer, IF(LOCATE('/', referer, 8) = 0, LENGTH(referer), LOCATE('/', referer, 8))) as `referer`,
						{$time_column}, 
						SUM(`click_price`) as clicks_price, 
						SUM(`conversion_price_main`) as conversions_sum, 
						SUM(`is_parent`) as parent_count, 
						`is_sale`, 
						`is_lead`, 
						COUNT(`id`) AS cnt
					FROM 
						`tbl_clicks`
					WHERE 
						{$time_filter}
						{$limited_to}
					GROUP BY 
						`"._str($main_column)."`, 
						LEFT(referer, IF(LOCATE('/', referer, 8) = 0, LENGTH(referer), LOCATE('/', referer, 8))), 
						`is_sale`, 
						`is_lead`,
						{$group_time_column}
					ORDER BY 
						`"._str($main_column)."`, 
						LEFT(referer, IF(LOCATE('/', referer, 8) = 0, LENGTH(referer), LOCATE('/', referer, 8))),
						{$order_time_column} ASC
						";
				break;

				default: 
					$sql="SELECT 
							`"._str($main_column)."`, 
							`"._str($group_by)."`, 
							{$time_column}, 
							SUM(`click_price`) as clicks_price, 
							SUM(`conversion_price_main`) as conversions_sum, 
							SUM(`is_parent`) as parent_count, 
							`is_sale`, 
							`is_lead`, 
							COUNT(`id`) AS cnt
						FROM 
							`tbl_clicks`
						WHERE 
							{$time_filter}
							{$limited_to}
						GROUP BY 
							`"._str($main_column)."`, 
							`"._str($group_by)."`, 
							`is_sale`, 
							`is_lead`,
							{$group_time_column}
						ORDER BY 
							`"._str($main_column)."`, 
							`"._str($group_by)."`,
							{$order_time_column} ASC
							";
				break;			
			}
		}

		$result=mysql_query($sql);
		while ($row=mysql_fetch_assoc($result))
		{
			if ($row[$main_column]==''){$row[$main_column]='{empty}';}
			$group_by_value=$row[$group_by];
			if ($group_by_value==''){$group_by_value='{empty}';}
								
			switch ($row['is_sale'].$row['is_lead'])
			{
				case '00': 
					$click_type='click';
				break;
				case '01': 
					$click_type='lead';
				break;
				case '10': 
					$click_type='sale';
				break;		
				case '11': 
					$click_type='sale_lead';
				break;		
			}

			if ($main_column==$group_by)
			{
				$arr_report_data[$row[$main_column]][$row[$time_column_alias]][$click_type]=array('cnt'=>$row['cnt'], 'cost'=>$row['clicks_price'], 'earnings'=>$row['conversions_sum'], 'is_parent_cnt'=>$row['parent_count']);
			}
			else
			{
				$arr_report_data[$row[$main_column]][$group_by_value][$row[$time_column_alias]][$click_type]=array('cnt'=>$row['cnt'], 'cost'=>$row['clicks_price'], 'earnings'=>$row['conversions_sum'], 'is_parent_cnt'=>$row['parent_count']);
			}
		}

		return $arr_report_data;
	}

	function get_clicks_report_element ($clicks_data, $leads_data, $sales_data, $saleleads_data)
	{ 
		if ((isset($clicks_data)) || (isset($leads_data)) || (isset($sales_data)) || isset($saleleads_data))
		{
			$clicks_count=array_sum (array($clicks_data['cnt'], $leads_data['cnt'], $sales_data['cnt'], $saleleads_data['cnt']));
			$leads_count=array_sum (array($leads_data['cnt'], $saleleads_data['cnt']));
			$sales_count=array_sum (array($sales_data['cnt'], $saleleads_data['cnt']));

			$clicks_cost=array_sum (array($clicks_data['cost'], $leads_data['cost'], $sales_data['cost'], $saleleads_data['cost']));			
			
			$sales_amount=array_sum (array($sales_data['earnings'], $saleleads_data['earnings']));
			$sales_amount_rub=$sales_amount*30;
			
			$profit_amount=$sales_amount-$clicks_cost;
			$profit_amount_rub=$profit_amount*30;

			if ($sales_count>0)
			{
				$conversion='1:'.round($clicks_count/$sales_count);
				$epc=$sales_amount/$clicks_count;
				$epc_rub=$epc*30;
			}
			else
			{
				$conversion="0:$clicks_count";
			}

			if ($leads_count>0)
			{
				$conversion_leads='<b>1:'.round($clicks_count/$leads_count).'</b>';
				$leads_clicks="<b>{$clicks_count}:{$leads_count}</b>";
				$lead_price=$clicks_cost/$leads_count;
				$lead_price_rub=($clicks_cost/$leads_count)*30;
			}
			else
			{
				$leads_clicks="{$clicks_count}:{$leads_count}";
				$conversion_leads="0:$clicks_count";
				$lead_price='';
				$lead_price_rub='';
			}

			// Round and format values
			$sales_amount=round($sales_amount, 2);
			$sales_amount_rub=round($sales_amount_rub, 2);
			$profit_amount=round($profit_amount, 2);
			$profit_amount_rub=round($profit_amount_rub, 2);
			
			if ($profit_amount==0)
			{
				$profit_amount="<span style='color:lightgray; font-weight:normal;'>$0</span>";
				$profit_amount_rub="<span style='color:lightgray; font-weight:normal;'>0р.</span>";
			}
			else
			{
				if ($profit_amount<0)
				{
					$profit_amount='<span style="color:red;">-$'.abs($profit_amount)."</span>";
					$profit_amount_rub="<span style='color:red;'>{$profit_amount_rub} р.</span>";						
				}
				else
				{
					$profit_amount='$'.$profit_amount;
					$profit_amount_rub=$profit_amount_rub.' р.';
				}
			}
			
			if (is_numeric ($lead_price)) {$lead_price='$'.round($lead_price, 2);}
			if (is_numeric ($lead_price_rub)) {$lead_price_rub=round($lead_price_rub, 2).'р.';}
			
			if ($epc>=0.01){$epc=round($epc, 2);}else{$epc=round($epc, 3);}
			if ($epc_rub>=0.01){$epc_rub=round($epc_rub, 2);}else{$epc_rub=round($epc_rub, 3);}


			if ($clicks_cost>0)
			{
				$roi=round(($sales_amount-$clicks_cost)/$clicks_cost*100).'%';
				if ($roi<=0){$roi="<span style='color:red;'>{$roi}</span>";}
			}
			else
			{
				$roi='';
			}

			if ($sales_count>0)
			{
				return "<span class='sdata leads leads_clicks'>{$leads_clicks}</span>
						<span class='sdata leads leads_conversion'>{$conversion_leads}</span> 
						<span class='sdata leads leads_price usd'>{$lead_price}</span>
						<span class='sdata leads leads_price rub'>{$lead_price_rub}</span>
						<b><span class='sdata clicks'>{$clicks_count}:{$sales_count}</span><span class='sdata conversion'>{$conversion}</span><span class='sdata sales usd'>{$profit_amount}</span><span class='sdata sales rub'>{$profit_amount_rub}</span><span class='sdata epc usd'>\${$epc}</span><span class='sdata epc rub'>{$epc_rub} р.</span><span class='sdata roi'>{$roi}</span></b></td>";				
			}
			else
			{
				return "<span class='sdata leads leads_clicks'>{$leads_clicks}</span>
						<span class='sdata leads leads_conversion'>{$conversion_leads}</span> 
						<span class='sdata leads leads_price'>{$lead_price}</span>
						<span class='sdata clicks'>{$clicks_count}</span><span class='sdata conversion'>{$conversion}</span><span class='sdata roi' style='color:lightgray;'>-</span>
						<span style='color:lightgray;' class='sdata epc usd'>$0</span><span style='color:lightgray;' class='sdata epc rub'>0 р.</span>
						<span class='sdata sales usd' style='font-weight:bold;'>{$profit_amount}</span><span class='sdata sales rub' style='font-weight:bold;'>{$profit_amount_rub}</span>";
			}
		}
		else
		{
			return '';
		}
	}
?>