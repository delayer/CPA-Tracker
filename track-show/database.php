<?
    $arr_sql[]="SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_clicks` (
      `id` int(11) NOT NULL auto_increment,
      `date_add` datetime NOT NULL,
      `date_add_day` date NOT NULL,
      `date_add_hour` tinyint(4) NOT NULL,
      `user_ip` varchar(255) NOT NULL,
      `user_agent` text character set utf8 NOT NULL,
      `user_os` varchar(255) character set utf8 NOT NULL,
      `user_os_version` varchar(255) character set utf8 NOT NULL,
      `user_platform` varchar(255) character set utf8 NOT NULL,
      `user_platform_info` varchar(255) character set utf8 NOT NULL,
      `user_platform_info_extra` varchar(255) character set utf8 NOT NULL,
      `user_browser` varchar(255) character set utf8 NOT NULL,
      `user_browser_version` varchar(255) character set utf8 NOT NULL,
      `is_mobile_device` tinyint(1) NOT NULL,
      `is_phone` tinyint(1) NOT NULL,
      `is_tablet` tinyint(1) NOT NULL,
      `country` varchar(255) NOT NULL,
      `state` varchar(255) character set utf8 NOT NULL,
      `city` varchar(255) character set utf8 NOT NULL,
      `region` varchar(255) character set utf8 NOT NULL,
      `isp` varchar(255) character set utf8 NOT NULL,
      `rule_id` int(11) NOT NULL,
      `out_id` int(11) NOT NULL,
      `subid` varchar(255) character set utf8 NOT NULL,
      `subaccount` varchar(255) character set utf8 NOT NULL,
      `source_name` varchar(255) character set utf8 NOT NULL,
      `campaign_name` varchar(255) character set utf8 NOT NULL,
      `ads_name` varchar(255) character set utf8 NOT NULL,
      `referer` text character set utf8 NOT NULL,
      `search_string` text character set utf8 NOT NULL,
      `click_price` decimal(10,4) NOT NULL,
      `conversion_price_main` decimal(10,4) NOT NULL,
      `is_lead` tinyint(1) NOT NULL,
      `is_sale` tinyint(1) NOT NULL,
      `campaign_param1` varchar(255) character set utf8 NOT NULL,
      `campaign_param2` varchar(255) character set utf8 NOT NULL,
      `campaign_param3` varchar(255) character set utf8 NOT NULL,
      `campaign_param4` varchar(255) character set utf8 NOT NULL,
      `campaign_param5` varchar(255) character set utf8 NOT NULL,
      `click_param_name1` varchar(255) character set utf8 NOT NULL,
      `click_param_value1` text character set utf8 NOT NULL,
      `click_param_name2` varchar(255) character set utf8 NOT NULL,
      `click_param_value2` text character set utf8 NOT NULL,
      `click_param_name3` varchar(255) character set utf8 NOT NULL,
      `click_param_value3` text character set utf8 NOT NULL,
      `click_param_name4` varchar(255) character set utf8 NOT NULL,
      `click_param_value4` text character set utf8 NOT NULL,
      `click_param_name5` varchar(255) character set utf8 NOT NULL,
      `click_param_value5` text character set utf8 NOT NULL,
      `click_param_name6` varchar(255) character set utf8 NOT NULL,
      `click_param_value6` text character set utf8 NOT NULL,
      `click_param_name7` varchar(255) character set utf8 NOT NULL,
      `click_param_value7` text character set utf8 NOT NULL,
      `click_param_name8` varchar(255) character set utf8 NOT NULL,
      `click_param_value8` text character set utf8 NOT NULL,
      `click_param_name9` varchar(255) character set utf8 NOT NULL,
      `click_param_value9` text character set utf8 NOT NULL,
      `click_param_name10` varchar(255) character set utf8 NOT NULL,
      `click_param_value10` text character set utf8 NOT NULL,
      `click_param_name11` varchar(255) character set utf8 NOT NULL,
      `click_param_value11` text character set utf8 NOT NULL,
      `click_param_name12` varchar(255) character set utf8 NOT NULL,
      `click_param_value12` text character set utf8 NOT NULL,
      `click_param_name13` varchar(255) character set utf8 NOT NULL,
      `click_param_value13` text character set utf8 NOT NULL,
      `click_param_name14` varchar(255) character set utf8 NOT NULL,
      `click_param_value14` text character set utf8 NOT NULL,
      `click_param_name15` varchar(255) character set utf8 NOT NULL,
      `click_param_value15` text character set utf8 NOT NULL,
      PRIMARY KEY  (`id`),
      UNIQUE KEY `subid` (`subid`),
      KEY `date_add_day` (`date_add_day`),
      KEY `date_add_hour` (`date_add_hour`),
      KEY `user_os` (`user_os`),
      KEY `user_platform` (`user_platform`),
      KEY `user_browser` (`user_browser`),
      KEY `country` (`country`),
      KEY `state` (`state`),
      KEY `city` (`city`),
      KEY `region` (`region`),
      KEY `rule_id` (`rule_id`),
      KEY `out_id` (`out_id`),
      KEY `subaccount` (`subaccount`),
      KEY `source_name` (`source_name`),
      KEY `campaign_name` (`campaign_name`),
      KEY `ads_name` (`ads_name`),
      KEY `campaign_param1` (`campaign_param1`),
      KEY `campaign_param2` (`campaign_param2`),
      KEY `campaign_param3` (`campaign_param3`),
      KEY `campaign_param4` (`campaign_param4`),
      KEY `campaign_param5` (`campaign_param5`),
      KEY `click_param_name1` (`click_param_name1`),
      KEY `click_param_name2` (`click_param_name2`),
      KEY `click_param_name3` (`click_param_name3`),
      KEY `click_param_name4` (`click_param_name4`),
      KEY `click_param_name5` (`click_param_name5`),
      KEY `click_param_name6` (`click_param_name6`),
      KEY `click_param_name7` (`click_param_name7`),
      KEY `click_param_name8` (`click_param_name8`),
      KEY `click_param_name9` (`click_param_name9`),
      KEY `click_param_name10` (`click_param_name10`),
      KEY `click_param_name11` (`click_param_name11`),
      KEY `click_param_name12` (`click_param_name12`),
      KEY `click_param_name13` (`click_param_name13`),
      KEY `click_param_name14` (`click_param_name14`),
      KEY `click_param_name15` (`click_param_name15`),
      KEY `is_lead` (`is_lead`),
      KEY `is_sale` (`is_sale`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";


    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_conversions` (
      `id` int(11) NOT NULL auto_increment,
      `type` varchar(255) character set utf8 NOT NULL,
      `network` varchar(255) character set utf8 NOT NULL,
      `subid` varchar(255) character set utf8 NOT NULL,
      `profit` decimal(10,4) NOT NULL,
      `date_add` datetime NOT NULL,
      `status` tinyint(4) NOT NULL,
      PRIMARY KEY  (`id`),
      KEY `type` (`type`),
      KEY `network` (`network`),
      KEY `subid` (`subid`),
      KEY `status` (`status`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_cpa_networks` (
      `id` int(11) NOT NULL auto_increment,
      `network_name` varchar(255) character set utf8 NOT NULL,
      `network_category_name` varchar(255) character set utf8 NOT NULL,
      `network_platform` varchar(255) character set utf8 NOT NULL,
      `network_domain` text character set utf8 NOT NULL,
      `registration_url` text character set utf8 NOT NULL,
      `network_api_url` text character set utf8 NOT NULL,
      `offer_page_url` text character set utf8 NOT NULL,
      `api_key` varchar(255) character set utf8 NOT NULL,
      `status` tinyint(4) NOT NULL default '0',
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_links_categories` (
      `id` int(11) NOT NULL auto_increment,
      `category_id` int(11) NOT NULL,
      `offer_id` int(11) NOT NULL,
      PRIMARY KEY  (`id`),
      KEY `category_id` (`category_id`,`offer_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_links_categories_list` (
      `id` int(11) NOT NULL auto_increment,
      `category_caption` varchar(255) character set utf8 NOT NULL,
      `category_name` varchar(255) character set utf8 NOT NULL,
      `category_type` varchar(255) character set utf8 NOT NULL,
      `status` tinyint(4) NOT NULL default '0',
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_offers` (
      `id` int(11) NOT NULL auto_increment,
      `network_id` int(11) NOT NULL,
      `offer_id` varchar(255) character set utf8 NOT NULL,
      `offer_name` text character set utf8 NOT NULL,
      `offer_description` text character set utf8 NOT NULL,
      `offer_payout_type` varchar(255) character set utf8 NOT NULL,
      `offer_payout` varchar(255) character set utf8 NOT NULL,
      `offer_payout_currency` varchar(255) character set utf8 NOT NULL,
      `offer_expiration_date` date NOT NULL,
      `offer_preview_url` text character set utf8 NOT NULL,
      `offer_tracking_url` text character set utf8 NOT NULL,
      `offer_comment` text character set utf8 NOT NULL,
      `is_active` tinyint(4) NOT NULL default '1',
      `date_add` datetime NOT NULL,
      `status` tinyint(4) NOT NULL default '0',
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_rules` (
      `id` int(11) NOT NULL auto_increment,
      `link_name` varchar(255) character set utf8 NOT NULL,
      `date_add` datetime NOT NULL,
      `status` int(11) NOT NULL default '0',
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_rules_items` (
      `id` int(11) NOT NULL auto_increment,
      `rule_id` int(11) NOT NULL,
      `parent_id` int(11) NOT NULL,
      `type` varchar(255) character set utf8 NOT NULL,
      `value` text character set utf8 NOT NULL,
      `status` int(11) NOT NULL default '0',
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_users` (
      `id` int(11) NOT NULL auto_increment,
      `email` varchar(255) character set utf8 NOT NULL,
      `password` varchar(255) character set utf8 NOT NULL,
      `salt` varchar(255) NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

    $arr_sql[]="ALTER TABLE  `tbl_clicks` ADD  `is_parent` BOOL NOT NULL AFTER  `is_sale` ;";
    $arr_sql[]="ALTER TABLE  `tbl_clicks` ADD  `is_connected` BOOL NOT NULL AFTER  `is_parent` ;";
    $arr_sql[]="ALTER TABLE  `tbl_clicks` ADD  `parent_id` INT NOT NULL AFTER  `is_connected` ;";

    $arr_sql[]="CREATE TABLE IF NOT EXISTS `tbl_timezones` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `timezone_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
    `timezone_offset_h` INT NOT NULL ,
    `is_active` INT NOT NULL ,
    `status` INT NOT NULL
    );";
    
    $arr_sql[]="UPDATE `tbl_offers` SET `offer_tracking_url` = REPLACE(`offer_tracking_url`, '%SUBID%', '[SUBID]')";
    
    $arr_sql[]="ALTER TABLE `tbl_conversions` ADD `txt_status` VARCHAR(255), ADD `txt_param1` TEXT,  ADD `txt_param2` TEXT,  ADD `txt_param3` TEXT ,  ADD `txt_param4` TEXT ,  ADD `txt_param5` TEXT ,  ADD `txt_param6` TEXT ,  ADD `txt_param7` TEXT ,  ADD `txt_param8` TEXT ,  ADD `txt_param9` TEXT ,  ADD `txt_param10` TEXT ,  ADD `txt_param11` TEXT ,  ADD `txt_param12` TEXT ,  ADD `txt_param13` TEXT ,  ADD `txt_param14` TEXT ,  ADD `txt_param15` TEXT ,  ADD `txt_param16` TEXT ,  ADD `txt_param17` TEXT ,  ADD `txt_param18` TEXT ,  ADD `txt_param19` TEXT ,  ADD `txt_param20` TEXT ,  ADD `txt_param21` TEXT ,  ADD `txt_param22` TEXT ,  ADD `txt_param23` TEXT ,  ADD `txt_param24` TEXT ,  ADD `txt_param25` TEXT ,   ADD `txt_param26` TEXT ,   ADD `txt_param27` TEXT ,   ADD `txt_param28` TEXT ,   ADD `txt_param29` TEXT ,   ADD `txt_param30` TEXT ,  ADD `float_param1` FLOAT(10,4) ,  ADD `float_param2` FLOAT(10,4) ,  ADD `float_param3` FLOAT(10,4) ,  ADD `float_param4` FLOAT(10,4) ,  ADD `float_param5` FLOAT(10,4) ,  ADD `int_param1` INT(11) ,  ADD `int_param2` INT(11) ,  ADD `int_param3` INT(11) ,  ADD `int_param4` INT(11) ,  ADD `int_param5` INT(11) ,  ADD `int_param6` INT(11) ,  ADD `int_param7` INT(11) ,  ADD `int_param8` INT(11) ,  ADD `int_param9` INT(11) ,  ADD `int_param10` INT(11) ,  ADD `int_param11` INT(11) ,  ADD `int_param12` INT(11) ,  ADD `int_param13` INT(11) ,  ADD `int_param14` INT(11) ,  ADD `int_param15` INT(11) ,  ADD `int_param16` INT(11) ,  ADD `int_param17` INT(11) ,  ADD `int_param18` INT(11) ,  ADD `int_param19` INT(11) ,  ADD `int_param20` INT(11) ,  ADD `date_param1` INT ,  ADD `date_param2` DATETIME ,  ADD `date_param3` DATETIME ,  ADD `date_param4` DATETIME ,  ADD `date_param5` DATETIME ";

?>