<?
	mysql_connect($_DB_HOST, $_DB_LOGIN, $_DB_PASSWORD) or die("Could not connect: " .mysql_error());
	mysql_select_db($_DB_NAME);
	mysql_db_query($_DB_NAME, 'SET NAMES utf8');
?>