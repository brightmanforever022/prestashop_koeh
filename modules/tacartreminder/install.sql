

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule` (
  `id_rule` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL DEFAULT '',
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `create_cart_rule` tinyint(1) NOT NULL DEFAULT '0',
  `id_cart_rule` int(10) NOT NULL DEFAULT '0',
  `cart_rule_nbday_validity` int(10) unsigned NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `force_reminder` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_rule`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_match_cache` (
  `id_rule_match_cache` int(11) unsigned NOT NULL auto_increment,
  `id_cart` int(11) unsigned,
  `return_jc` tinyint(1) NOT NULL DEFAULT '0',
  `date_check` datetime NOT NULL,
  `result` longtext,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_rule_match_cache`),
  KEY `id_cart` (`id_cart`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_shop` (
  `id_rule` int(11) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_rule`,`id_shop`),
  KEY `id_shop` (`id_shop`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_reminder` (
  `id_reminder` int(11) unsigned NOT NULL auto_increment,
  `id_rule` int(11) NOT NULL,
  `manual_process` tinyint(1) NOT NULL DEFAULT '0',
  `id_mail_template` int(11) NULL ,
  `admin_mails` VARCHAR(255) NULL,
  `nb_hour` DECIMAL(9,2) NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_reminder`),
  KEY `id_rule` (`id_rule`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_journal` (
  `id_journal` int(11) unsigned NOT NULL auto_increment,
  `id_shop` int(11) NOT NULL DEFAULT '1',
  `id_cart` int(11) NOT NULL,
  `id_cart_rule` int(11) NULL DEFAULT '0',
  `id_order` int(11) NULL DEFAULT '0',
  `id_customer` int(11) NOT NULL,
  `email` VARCHAR(128) NULL,
  `id_rule` int(11) NOT NULL,
  `rule_name` varchar(128) NOT NULL DEFAULT '',
  `state` enum('RUNNING', 'FINISHED', 'CANCELED') NOT NULL DEFAULT 'RUNNING',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `date_upd_cart` datetime NOT NULL, 
  PRIMARY KEY (`id_journal`),
  KEY `id_cart` (`id_cart`),
  KEY `id_customer` (`id_customer`),
  KEY `state` (`state`),
  KEY `email` (`email`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_journal_reminder` (
  `id_journal`  int(11) unsigned NOT NULL,
  `id_reminder` int(11) NOT NULL,
  `id_employee` int(11) NULL,
  `id_mail_template` int(11) NULL,
  `id_order` int(11) NULL DEFAULT '0',
  `mail_name` varchar(128) NOT NULL DEFAULT '',
  `uid_track_read` varchar(30) NOT NULL DEFAULT '',
  `isopen` tinyint(1) NOT NULL DEFAULT '0',
  `isclick` tinyint(1) NOT NULL DEFAULT '0',
  `manual_process` tinyint(1) NOT NULL DEFAULT '0',
  `performed` tinyint(1) NOT NULL DEFAULT '0',
  `date_performed` datetime NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL, 
  PRIMARY KEY (`id_journal`,`id_reminder`),
  KEY `id_journal` (`id_journal`),
  KEY `manual_process` (`manual_process`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_journal_message` (
  `id_message` int(11) unsigned NOT NULL auto_increment,
  `id_journal` int(11) unsigned NOT NULL,
  `id_reminder` int(11) NOT NULL,
  `id_employee` int(11) DEFAULT '0',
  `is_system`  tinyint(1) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL, 
  PRIMARY KEY (`id_message`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_customer_unsubscribe`(
 `id_unsubscribe` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `id_customer` int(11) unsigned NOT NULL,
 `id_shop` int(10) unsigned NOT NULL,
 `email` VARCHAR(128) NULL,
 `date_add` datetime NOT NULL,
 `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_unsubscribe`),
  KEY `email` (`email`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_groupcondition` (
  `id_groupcondition` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_rule` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_groupcondition`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_condition` (
  `id_condition` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_groupcondition` int(11)  unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_condition`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_rule_condition_value` (
  `id_condition_value` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `id_condition` int(11) unsigned NOT NULL,
  `id_item` int(11)  NULL,
  `value` varchar(256)  NULL,
  `typevalue` enum('string', 'integer', 'float','list','bool') NULL,
  `sign` enum('=', '<', '>','<=','>=','<>','contain','not_contain','match') NULL,
  PRIMARY KEY (`id_condition_value`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_mail_template` (
  `id_mail_template` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL, 
  PRIMARY KEY (`id_mail_template`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_mail_template_lang` (
  `id_mail_template` int(11) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `subject` varchar(256) NULL,
  `title` varchar(255) NULL,
  `content_html` longtext,
  `content_txt` longtext,
  PRIMARY KEY (`id_mail_template`,`id_lang`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_mail_template_shop` (
  `id_mail_template` int(11) unsigned NOT NULL,
  `id_shop` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_mail_template`,`id_shop`),
  KEY `id_shop` (`id_shop`)
) ENGINE=ENGINE_TYPE  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `PREFIX_ta_cartreminder_reassigned_cart` (
  `id_cart_reassigned` INT(10) NOT NULL,
  `id_cart` INT(10) NOT NULL,
  `date_add` DATETIME NOT NULL,
  PRIMARY KEY (`id_cart_reassigned`));
