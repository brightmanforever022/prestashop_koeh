<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql []= 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'burgel_call` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `raw_data` text NOT NULL,
  `resp_firstname` varchar(40)  NOT NULL,
  `resp_lastname` varchar(40)  NOT NULL,
  `resp_street` varchar(255)  NOT NULL,
  `resp_house_number` varchar(20)  NOT NULL,
  `resp_score` float(4,2) NOT NULL,
  `call_date` datetime NOT NULL,
  `resp_city` varchar(40)  NOT NULL,
  `resp_decision_text` varchar(255)  NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  cache_used tinyint not null,
  `order_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resp_firstname` (`resp_firstname`),
  KEY `resp_lastname` (`resp_lastname`),
  KEY `resp_street` (`resp_street`),
  KEY `resp_score` (`resp_score`),
  KEY `call_date` (`call_date`),
  KEY `city` (`resp_city`),
  KEY `customer_id` (`customer_id`, address_id),
  KEY `order_id` (`order_id`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}