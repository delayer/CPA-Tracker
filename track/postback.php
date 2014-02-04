<?php
	$data = serialize($_GET)."\n";
	// Save postback information in file	
	if (strlen ($data)>0)
	{
//		$str="{$type}\t{$amount}\t{$currency}\t{$subid}\n";
		file_put_contents(dirname (__FILE__).'/cache/postback/.postback_'.date('Y-m-d-H-i'), $data, FILE_APPEND | LOCK_EX);		
	}

        