<?
	ob_start();
	set_time_limit(0);
	$include_flag=true;
	
	include "functions_general.php";

	disable_magic_quotes();

	// Check file with db and server settings
	$settings=check_settings();

	$arr_settings=$settings[1];
	$_DB_LOGIN=$arr_settings['login'];
	$_DB_PASSWORD=$arr_settings['password'];
	$_DB_NAME=$arr_settings['dbname'];
	$_DB_HOST=$arr_settings['dbserver'];

	include "functions_report.php";
	include "../track/connect.php";

	$date=$_REQUEST['date'];
	$limit=$_REQUEST['limit'];
	$page=$_REQUEST['page'];
	$offset=$page*$limit;

	header('Content-Disposition: attachment; filename=report.txt');

	// Get data for report
	$arr_data=array();
	$sql="select tbl_offers.offer_name, tbl_clicks.date_add, tbl_clicks.user_ip, tbl_clicks.user_agent, tbl_clicks.user_os, tbl_clicks.user_platform, tbl_clicks.user_browser, tbl_clicks.country, tbl_clicks.subid, tbl_clicks.source_name, tbl_clicks.campaign_name, tbl_clicks.ads_name, tbl_clicks.referer, tbl_clicks.conversion_price_main from tbl_clicks left join tbl_offers on tbl_offers.id=tbl_clicks.out_id where date_add_day='".mysql_real_escape_string($date)."' limit ".mysql_real_escape_string($limit)." offset ".mysql_real_escape_string($offset)."";

	$result=mysql_query($sql);
	$arr_data=array();
	while ($row=mysql_fetch_assoc($result))
	{
		echo implode ("\t", $row);
		echo "\n";
	}

	exit();
?>