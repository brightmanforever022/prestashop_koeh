<?php
/**
* Leo Prestashop Theme Framework for Prestashop 1.5.x
*
*  @package   leotempcp
*  @version   3.0
*  @author    http://www.leotheme.com
*  @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>,<info@leotheme.com>.All rights reserved.
*  @license   GNU General Public License version 2
*/

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2($object)
{
	return ($object->registerHook('displayNav'));
}
