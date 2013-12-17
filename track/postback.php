<?
	$type=$_REQUEST['t'];
	$amount=$_REQUEST['a'];
	$currency=$_REQUEST['c'];
	$subid=$_REQUEST['s'];

	// Save postback information in file	
	if (strlen ($subid)>0)
	{
		$str="{$type}\t{$amount}\t{$currency}\t{$subid}\n";
		file_put_contents(dirname (__FILE__).'/cache/postback/.postback_'.date('Y-m-d-H-i'), $str, FILE_APPEND | LOCK_EX);		
	}
?>